<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\Image;
use Carbon\Carbon;

class CleanupImages extends Command
{
    protected $signature = 'app:cleanup-images';
    protected $description = '一時保存ファイルおよびDBと紐付かない孤立した画像を削除します';

    public function handle()
    {
        $this->info('Starting TmpImage cleanup...');
        $oldTmpImages = \App\Models\TmpImage::where('created_at', '<', now()->subDay())->get();

        if ($oldTmpImages->isEmpty()) {
            $this->info('No expired TmpImage records found.');
            return;
        }

        foreach ($oldTmpImages as $tmpImage) {
            if (Storage::disk('public')->exists($tmpImage->file_path)) {
                Storage::disk('public')->delete($tmpImage->file_path);
                $this->line("Deleted file: {$tmpImage->file_path}");
            }
            $tmpImage->delete();
            $this->line("Deleted TmpImage record (ID: {$tmpImage->id})");
        }


        $this->info('Checking for orphaned content images...');
        $contentFiles = Storage::disk('public')->allFiles('content');

        foreach ($contentFiles as $file) {
            if (preg_match('/^content\/(\d+)\//', $file, $matches)) {
                $contentId = $matches[1];
                $content = \App\Models\Content::find($contentId);

                if (!$content || !str_contains($content->body, $file)) {
                    Storage::disk('public')->delete($file);
                    $this->line("Deleted orphaned content image: {$file}");
                }
            }
        }

        $this->info('Cleanup completed!');
    }
}
