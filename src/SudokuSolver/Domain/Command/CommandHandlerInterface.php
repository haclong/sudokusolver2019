<?php

namespace Sudoku\Domain\Command;

/**
 *
 * @author haclong
 */
interface CommandHandlerInterface {
    public function handle(CommandInterface $command) ;
}
