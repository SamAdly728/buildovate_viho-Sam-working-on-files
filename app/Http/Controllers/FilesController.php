<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\UserFileUpload;
use App\Repositories\FilesRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;
use function Symfony\Component\Translation\t;

class FilesController extends Controller
{
    /**
     * @var FilesRepository
     */
    private FilesRepository $file;
    public function __construct(FilesRepository $file)
    {
        $this->file = $file;
    }
    public function index()
    {
            return Inertia::render('Files', [
                'userFile' => $this->file->getFiles(),
                'userFolder' => $this->file->getFolders()
            ]);

//        return Inertia::render('Files');

    }

    public function getJobsFile($jobsiteId)
    {
        return $this->file->getFiles(null, $jobsiteId);
    }

    public function getFolderContent(Request $request, $folderId)
    {
        return Inertia::render('UsersFolderContent',[
            'folderContent' => $this->file->getFolderContent($request->all(), $folderId)
        ]);
    }

    public function saveUserUploadFile(Request $request)
    {
        return $this->file->saveFile($request);
    }

    public function deleteUserFileUpload(Request $request)
    {
        return $this->file->deleteFile($request->all());
    }

    public function designs(Request $request)
    {
        return Inertia::render('files/Design',[
            'designsFile' => $this->file->getDesignFiles(),
            'userFolder' => $this->file->getFolders()
        ]);
    }

    public function contracts(Request $request)
    {
        return Inertia::render('files/Contract', [
            'contractsFile' => $this->file->getContractFiles(),
            'userFolder' => $this->file->getFolders()
        ]);
    }

    public function checklists()
    {
        return Inertia::render('files/Checklist', [
            'checklistsFile' => $this->file->getChecklist(),
            'userFolder' => $this->file->getFolders()
        ]);
    }

    public function engineerings(Request $request)
    {
        return Inertia::render('files/EngineeringPlan', [
            'engineeringsFile' => $this->file->getEngineering(),
            'userFolder' => $this->file->getFolders()
        ]);
    }

    public function sites(Request $request)
    {
        return Inertia::render('files/SitePlan', [
            'sitePlanFile' => $this->file->getSitePlan(),
            'userFolder' => $this->file->getFolders()
        ]);
    }

    public function architecturals(Request $request)
    {
        return Inertia::render('files/Architectural', [
            'architecturalFile' => $this->file->getArchitectural(),
            'userFolder' => $this->file->getFolders()
        ]);
    }

    public function permits(Request $request)
    {
        return Inertia::render('files/Permit', [
            'permitFile' => $this->file->getPermit(),
            'userFolder' => $this->file->getFolders()
        ]);
    }

    public function inspections(Request $request)
    {
        return Inertia::render('files/Inspection', [
            'inspectionFile' => $this->file->getInspection(),
            'userFolder' => $this->file->getFolders()
        ]);
    }

    public function warranties(Request $request)
    {
        return Inertia::render('files/Warranty', [
            'warrantyFile' => $this->file->getWarranty(),
            'userFolder' => $this->file->getFolders()
        ]);
    }

    public function documents(Request $request)
    {
        return Inertia::render('files/Document', [
            'documentFile' => $this->file->getDocument(),
            'userFolder' => $this->file->getFolders()
        ]);
    }

    public function photos(Request $request)
    {
        return Inertia::render('files/Photos', [
            'photoFile' => $this->file->getPhotos(),
            'userFolder' => $this->file->getFolders()
        ]);
    }

    public function videos(Request $request)
    {
        return Inertia::render('files/Videos', [
            'videoFile' => $this->file->getVideos(),
            'userFolder' => $this->file->getFolders()
        ]);
    }

    public function googleDrive()
    {
        return Inertia::render('files/GoogleDrive', [
            'userFolder' => $this->file->getFolders()
        ]);
    }

    public function dropbox()
    {
        return Inertia::render('files/Dropbox', [
            'userFolder' => $this->file->getFolders()
        ]);
    }

    public function starred()
    {
        return Inertia::render('files/Starred', [
            'starredFile' => $this->file->getStarred(),
            'userFolder' => $this->file->getFolders()
        ]);
    }

    public function trash()
    {
        return Inertia::render('files/Trash', [
            'trashedFile' => $this->file->getTrashed('files'),
            'userFolder' => $this->file->getFolders()
        ]);
    }

    public function settings()
    {
        return Inertia::render('files/Settings', [
            'userFolder' => $this->file->getFolders()
        ]);
    }

    public function updateFavorite(Request $request)
    {
        return $this->file->updateFav($request->all());
    }

    public function restoreTrashed(Request $request)
    {
        return $this->file->restoreFile($request->all());
    }

    public function previewFile($fileId)
    {
        return $this->file->previewFile($fileId);
    }

    public function bulkDownload(Request $request)
    {
        return $this->file->bulkDownload($request);
    }

    public function saveNewFolder(Request $request)
    {
        return $this->file->createNewFolder($request->all());
    }

    public function moveFileTo(Request $request)
    {
        return $this->file->moveFile($request->all());
    }
}
