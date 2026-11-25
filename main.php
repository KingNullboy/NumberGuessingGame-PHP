<?php
	echo "KingNullboy's PHP Number Guessing Game\n";

	while (true) {
		$num = random_int(1, 100);
		$guess = -1;

		if (!file_exists("save.txt") || strlen(file_get_contents("save.txt")) == 0) {
			file_put_contents("save.txt", "0,0");
		}
		[$plays, $wins] = explode(",", file_get_contents("save.txt"));
		$plays++;

		echo "You have played this game ".($plays-1)." time".($plays-1 == 1 ? '' : 's').", and won it $wins of those times for a total win rate of ".($wins/max(1,$plays-1)*100)."%.\n";

		while ($num != $guess) {
			try {
				$answer = readline("What is your guess of the secret number? (1-100)\n> ");
				if (!is_numeric($answer)) {
					throw new Exception("High quanity of NaN bread detected");
				}
				$guess = (int) $answer;
			} catch (Exception $e) {
				echo "Buddy, that's not a number. Defaulting to 50.\n";
				$guess = 50;
			}

			if ($guess < 1 || $guess > 100) {
				echo "That's not a number between 1 and 100. Can't you read?\n";
			} elseif ($guess > $num) {
				echo "That number is greater than the secret number.\n";
			} elseif ($guess < $num) {
				echo "That number is less than the secret number.\n";
			} elseif ($guess == $num) {
				echo "You win!\n";
				$wins++;
			}
		}

		file_put_contents("save.txt", "$plays,$wins");

		$again = null;
		while (true) {
			$again = readline("Play again? (Y/n)\n> ");
			if (!(str_starts_with(strtolower($again), "y") || str_starts_with(strtolower($again), "n"))) {
				echo "That doesn't start with yes or no. Can't you read?\n";
				continue;
			}
			break;
		}

		if (str_starts_with(strtolower($again), "y")) {
			continue;
		} else {
			break;
		}
	}