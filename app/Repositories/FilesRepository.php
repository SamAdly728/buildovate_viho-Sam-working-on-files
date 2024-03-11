<?php

namespace App\Repositories;

use App\Models\UserFileFolder;
use App\Models\UserFileUpload;
use App\Services\S3Manager;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use ZipArchive;

class FilesRepository
{
    public function getDesignFiles()
    {
        return $this->getFiles('design');
    }

    public function getContractFiles()
    {
        return $this->getFiles('contract');
    }

    public function getChecklist()
    {
        return $this->getFiles('checklist');
    }

    public function getEngineering()
    {
        return $this->getFiles('engineering');
    }

    public function getSitePlan()
    {
        return $this->getFiles('siteplan');
    }

    public function getArchitectural()
    {
        return $this->getFiles('architectural');
    }

    public function getPermit()
    {
        return $this->getFiles('permit');
    }

    public function getInspection()
    {
        return $this->getFiles('inspection');
    }

    public function getWarranty()
    {
        return $this->getFiles('warranty');
    }

    public function getDocument()
    {
        return $this->getFiles('document');
    }

    public function getPhotos()
    {
        return $this->getFiles('photos');
    }

    public function getVideos()
    {
        return $this->getFiles('videos');
    }

    public function getStarred()
    {
        $userFile = UserFileUpload::where('user_id', session()->get('user_id'))->where('favorite', 1)->get();

        $s3 = new S3Manager();

        foreach($userFile as $file) {
            if ($file->file_type == 'pdf') {
                $file->s3Url = url('assets/images/pdf.png');
                $file->tempUrl = $s3->preview($file->s3_path);
            } else {
                $file->s3Url = $s3->getUrl($file->s3_path);
                $file->tempUrl = $s3->preview($file->s3_path);
            }
        }

        return $userFile;
    }

    public function getTrashed($pageFrom = null)
    {
        if ($pageFrom) {
            $trashed = UserFileUpload::where('user_id', session()->get('user_id'))->where('page_from', $pageFrom)->onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        } else {
            $trashed = UserFileUpload::where('user_id', session()->get('user_id'))->where('page_from', $pageFrom)->onlyTrashed()->get();
        }

        $s3 = new S3Manager();
        foreach ($trashed as $trash) {
            $trash->s3Url = $s3->getUrl($trash->s3_path);
        }
        return $trashed;
    }

    public function getFiles($from = null, $jobsiteId = null, $folderId = null, $pageFrom = null)
    {
        if ($from) {
            $userFile = UserFileUpload::where('user_id', session()->get('user_id'))->where('upload_from', $from)->get();
        }elseif($jobsiteId) {
            $userFile = UserFileUpload::where('user_id', session()->get('user_id'))->where('jobsite_id', $jobsiteId)->orderByDesc('created_at')->get();
        }elseif($folderId){
            $userFile = UserFileUpload::where('user_id', session()->get('user_id'))->where('folder_id', $folderId)->get();
        } elseif($pageFrom){
            $userFile = UserFileUpload::where('user_id', session()->get('user_id'))->where('page_from', $pageFrom)->orderByDesc('created_at')->get();
        } else {
            $userFile = UserFileUpload::where('user_id', session()->get('user_id'))->orderByDesc('created_at')->get();
        }

        $s3 = new S3Manager();

        foreach($userFile as $file) {
            if ($file->file_type == 'pdf') {
                $file->s3Url = url('assets/images/pdf.png');
                $file->tempUrl = $s3->preview($file->s3_path);
            } else {
                $file->s3Url = $s3->getUrl($file->s3_path);
                $file->tempUrl = $s3->preview($file->s3_path);
            }
        }

        return $userFile;
    }

    public function getRecentFiles()
    {
        $userFile = UserFileUpload::where('user_id', session()->get('user_id'))->orderByDesc('created_at')->take(5)->get();

        $s3 = new S3Manager();

        foreach($userFile as $file) {
            if ($file->file_type == 'pdf') {
                $file->s3Url = url('assets/images/pdf.png');
                $file->tempUrl = $s3->preview($file->s3_path);
            } else {
                $file->s3Url = $s3->getUrl($file->s3_path);
                $file->tempUrl = $s3->preview($file->s3_path);
            }
        }

        return $userFile;
    }

    public function saveFile($request)
    {

        $fileFrom = $request['upload-file-from'];
        $file = $request['file'];
        $jobsiteId = $request['jobsite_id'];
        $s3Path = 'userfileupload/'.$fileFrom.'/'.session()->get('user_id').'/'.md5(rand(1000,1000)).'-'.$file->getClientOriginalName();

        $fileTable = new UserFileUpload();
        $fileTable->user_id = session()->get('user_id');
        $fileTable->file_name = $file->getClientOriginalName();
        $fileTable->file_type = $file->getClientOriginalExtension();
        $fileTable->file_size = $file->getSize();
        $fileTable->s3_path = $s3Path;
        $fileTable->upload_from = $fileFrom;
        $fileTable->jobsite_id = $jobsiteId;
        $fileTable->folder_id = $request['folder-id'] ?? null;
        $fileTable->page_from = $request['page-from'] ?? null;
        $fileTable->save();

        $s3 = new S3Manager();
        $s3->store($file, $s3Path);

        $fileTable->s3Url = $s3->getUrl($fileTable->s3_path);

        return $fileTable;
    }

    public function deleteFile($request)
    {
        foreach ((array)$request['selectedFileId'] as $file) {
            $selectFile = UserFileUpload::where('user_file_upload_id', $file)->first();
            $selectFile->delete();
        }

        return true;
    }

    public function updateFav($request)
    {
        $upload = UserFileUpload::where('user_file_upload_id', $request['upload-id'])->first();
        $upload->favorite = $request['flag'];
        $upload->save();

        return $upload;
    }

    public function restoreFile($request)
    {
        return UserFileUpload::withTrashed()->find($request['keyId'])->restore();
    }

    /**
     * @throws BindingResolutionException
     */
    public function previewFile($key)
    {
        $file = UserFileUpload::where('user_file_upload_id', $key)->first();

        $s3 = new S3Manager();

        $s3File = $s3->getFileContents($file->s3_path);
        $previewFile = $s3File['contents'];

        $contentType = '';

        $imageTypes = ['png', 'jpg', 'jpeg', 'avif', 'webp', 'JPG', 'PNG', 'JPEG', 'AVIF', 'WEBP'];

        if (in_array($file->file_type, $imageTypes)) {
            $contentType = ['content-type' => 'image/jpg'];
        }

        if ($file->file_type == 'pdf') {
            $contentType = ['content-type' => 'application/pdf'];
        }

        if ($file->file_type == 'mp4') {
            $contentType = ['content-type' => 'video/mp4'];
        }

        return response()->make($previewFile, 200, $contentType);
    }

    public function bulkDownload($request)
    {
        $fileS3Path = UserFileUpload::whereIn('user_file_upload_id', $request->get('selectedFileId'))->get()->pluck('s3_path');
        $s3 = new S3Manager();

        $zipFileName = 'files.zip'; // name of the ZIP file
        $zip = new ZipArchive();

        if ($zip->open($zipFileName, ZipArchive::CREATE) !== TRUE) {
            exit("Cannot open <$zipFileName>\n");
        }

        foreach ($fileS3Path as $object) {
            try {
                $result = $s3->s3Credentials()->getObject([
                    'Bucket' => env('AWS_BUCKET'),
                    'Key'    => $object
                ]);

                $zip->addFromString(basename($object), (string) $result['Body']);
            } catch (AwsException $e) {
                echo "Error: " . $e->getMessage();
            }
        }

        $zip->close();

        return response()->download(public_path($zipFileName))->deleteFileAfterSend(true);
    }

    public function getFolderContent($request, $folderId)
    {
        return UserFileUpload::leftJoin('users_file_folder', function($join) {
            $join->on('users_file_upload.folder_id', '=', 'users_file_folder.file_folder_id');
        })->where('users_file_upload.folder_id', '=', $folderId)->get();
    }

    public function getFolders()
    {
        return UserFileFolder::where('user_id', session()->get('user_id'))->where('added_from_page', 'files')->get();
    }

    public function createNewFolder($request)
    {
        $fileFolderPath = 'User-File-Folder/'.session()->get('user_id').'/'.$request['new-folder-name'].'/';
        $s3 = new S3Manager();
        $fileFolder = new UserFileFolder();
        $fileFolder->user_id = session()->get('user_id');
        $fileFolder->folder_name = $request['new-folder-name'];
        $fileFolder->s3_path = $fileFolderPath;
        $fileFolder->added_from_page = $request['added-from'];
        $fileFolder->jobsite_id = $request['jobsite-id'] ?? null;
        $fileFolder->save();

        $s3->createFolder($fileFolderPath);
        return $fileFolder;
    }

    public function moveFile($request)
    {
        foreach($request['file-ids'] as $fileId) {
            $usersFile = UserFileUpload::find($fileId);
            $usersFile->upload_from = $request['move-to-folder'];
            $usersFile->save();
        }
        return true;
    }
}