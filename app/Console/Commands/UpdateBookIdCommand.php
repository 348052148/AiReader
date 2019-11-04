<?php

namespace App\Console\Commands;

use App\Book;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateBookIdCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:bookId';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $books = Book::all();
        $count = 0;
        foreach ($books as $book) {
            $res = $book->update(['book_id' => md5(trim($book->title).trim($book->author))]);
            Log::info("",[$res]);
            $count++;
        }
        echo $count;
    }
}
