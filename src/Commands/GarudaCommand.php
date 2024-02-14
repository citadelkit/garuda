<?php

namespace CitadelKit\Garuda\Commands;

use Illuminate\Console\Command;

class GarudaCommand extends Command
{
    public $signature = 'garuda';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
