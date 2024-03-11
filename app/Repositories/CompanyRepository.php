<?php
namespace App\Repositories;

use App\Models\Company;
use App\Models\CompanyEmail;
use App\Models\CompanyHours;
use App\Models\CompanyLocation;
use App\Models\CompanyNumber;
use App\Models\CompanyOverhead;
use App\Models\CompanySocialMedia;
use App\Models\CompanyWebsite;
use App\Models\UserFileFolder;
use App\Models\UserFileUpload;
use App\Models\CompanyFileUpload;
use App\Services\S3Manager;
use Carbon\Carbon;

class CompanyRepository
{
    /**
     * @return mixed
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function getCompanyDetails(): mixed
    {
        return Company::where('user_id', session()->get('user_id'))->first();
    }

    /**
     * @return mixed
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function getCompanyMonthlyOverhead(): mixed
    {
        return CompanyOverhead::where('company_id', $this->getCompany()->company_id)->get();
    }

    /**
     * @param $request
     * @return CompanyOverhead
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function saveOrEditMonthlyOverHead($request): CompanyOverhead
    {
        $checkIfAlreadyExist = CompanyOverhead::where('company_monthly_overhead_id', $request['overHeadHiddenId'])->first();

        if ($checkIfAlreadyExist) {
            $checkIfAlreadyExist->expense_name = $request['overHeadTitle'];
            $checkIfAlreadyExist->expense_amount = $request['OverHeadAmount'];
            $checkIfAlreadyExist->edited_by = session()->get('user_id');
            $checkIfAlreadyExist->save();
            return $checkIfAlreadyExist;
        } else {

            $overhead = new CompanyOverhead();
            $overhead->company_id = $this->getCompany()->company_id;
            $overhead->expense_name = $request['overHeadTitle'];
            $overhead->expense_amount = $request['OverHeadAmount'];
            $overhead->added_by = session()->get('user_id');
            $overhead->date_created = Carbon::now();
            $overhead->save();
            return $overhead;
        }

    }

    /**
     * @param $request
     * @return mixed
     */
    public function deleteOverhead($request): mixed
    {
        return CompanyOverhead::where('company_monthly_overhead_id', $request['company_monthly_overhead_id'])->delete();
    }

    /**
     * @param $request
     * @return CompanyNumber
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function saveOrEditPhoneNumber($request): CompanyNumber
    {
        $companyNumber = CompanyNumber::where('company_number_id', $request['phoneNumberHiddenId'])->first();

        if ($companyNumber) {
            $companyNumber->number_title = $request['phoneNumberTitle'];
            $companyNumber->company_number = $request['phoneNumber'];
            $companyNumber->updated_by = session()->get('user_id');
            $companyNumber->is_primary = $request['phoneNumberIsPrimary'] ?? 0;
            $companyNumber->save();
            return $companyNumber;
        } else {
            $newCompanyNumber = new CompanyNumber();
            $newCompanyNumber->company_id = $this->getCompany()->company_id;
            $newCompanyNumber->number_title = $request['phoneNumberTitle'];
            $newCompanyNumber->company_number = $request['phoneNumber'];
            $newCompanyNumber->added_by = session()->get('user_id');
            $newCompanyNumber->is_primary = $request['phoneNumberIsPrimary'] ?? 0;
            $newCompanyNumber->save();
            return $newCompanyNumber;
        }
    }

    /**
     * @param $request
     * @return mixed
     */
    public function deletePhoneNumber($request): mixed
    {
        return CompanyNumber::where('company_number_id', $request['company_number_id'])->delete();
    }

    /**
     * @return mixed
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function getCompanyPhoneNumbers(): mixed
    {
        return CompanyNumber::where('company_id', $this->getCompany()->company_id)->get();
    }

    /**
     * @return mixed
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function getCompanyEmail(): mixed
    {
        return CompanyEmail::where('company_id', $this->getCompany()->company_id)->get();
    }

    /**
     * @param $request
     * @return CompanyEmail
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function saveEmail($request): CompanyEmail
    {
        $companyEmail = CompanyEmail::where('company_email_id', $request['emailHiddenId'])->first();

        if ($companyEmail) {
            $companyEmail->company_id = $this->getCompany()->company_id;
            $companyEmail->email_title = $request['emailTitle'];
            $companyEmail->company_email = $request['email'];
            $companyEmail->is_primary = $request['emailIsPrimary'] ?? 0;
            $companyEmail->updated_by = session()->get('user_id');
            $companyEmail->save();
            return $companyEmail;
        } else {
            $newCompanyEmail = new CompanyEmail();
            $newCompanyEmail->company_id = $this->getCompany()->company_id;
            $newCompanyEmail->email_title = $request['emailTitle'];
            $newCompanyEmail->company_email = $request['email'];
            $newCompanyEmail->is_primary = $request['emailIsPrimary'] ?? 0;
            $newCompanyEmail->added_by = session()->get('user_id');
            $newCompanyEmail->save();
            return $newCompanyEmail;
        }
    }

    /**
     * @param $request
     * @return mixed
     */
    public function deleteEmail($request): mixed
    {
        return CompanyEmail::where('company_email_id', $request['company_email_id'])->delete();
    }

    /**
     * @return mixed
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function getCompanyLocation(): mixed
    {
        return CompanyLocation::where('company_id', $this->getCompany()->company_id)->get();
    }

    /**
     * @param $request
     * @return CompanyLocation
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function saveAddress($request): CompanyLocation
    {
        $companyAddress = CompanyLocation::where('company_location_id', $request['addressHiddenId'])->first();

        if ($companyAddress) {
            $companyAddress->company_id = $this->getCompany()->company_id;
            $companyAddress->location_address = $request['companyAddress'];
            $companyAddress->location_street = $request['companyStreet'];
            $companyAddress->location_city = $request['companyCity'];
            $companyAddress->location_zipcode = $request['companyZip'];
            $companyAddress->is_primary = $request['addressIsPrimary'];
            $companyAddress->updated_by = session()->get('user_id');
            $companyAddress->save();
            return $companyAddress;
        } else {
            $newCompanyLocation = new CompanyLocation();
            $newCompanyLocation->company_id = $this->getCompany()->company_id;
            $newCompanyLocation->location_address = $request['companyAddress'];
            $newCompanyLocation->location_street = $request['companyStreet'];
            $newCompanyLocation->location_city = $request['companyCity'];
            $newCompanyLocation->location_zipcode = $request['companyZip'];
            $newCompanyLocation->is_primary = $request['addressIsPrimary'];
            $newCompanyLocation->added_by = session()->get('user_id');
            $newCompanyLocation->save();
            return $newCompanyLocation;
        }
    }

    /**
     * @param $request
     * @return mixed
     */
    public function deleteAddress($request): mixed
    {
        return CompanyLocation::where('company_location_id', $request['company_location_id'])->delete();
    }

    /**
     * @return mixed
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function getCompanyWebsites(): mixed
    {
        return CompanyWebsite::where('company_id', $this->getCompany()->company_id)->get();
    }

    /**
     * @param $request
     * @return CompanyWebsite
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function saveWebsite($request): CompanyWebsite
    {
        $website = CompanyWebsite::where('company_website_id', $request['companyWebHiddenId'])->first();

        if ($website) {
            $website->company_id = $this->getCompany()->company_id;
            $website->website_name = $request['companyWebName'];
            $website->company_website = $request['companyWebUrl'];
            $website->is_primary = $request['companyWebIsPrimary'];
            $website->updated_by = session()->get('user_id');
            $website->save();
            return $website;
        } else {
            $newWebsite = new CompanyWebsite();
            $newWebsite->company_id = $this->getCompany()->company_id;
            $newWebsite->website_name = $request['companyWebName'];
            $newWebsite->company_website = $request['companyWebUrl'];
            $newWebsite->is_primary = $request['companyWebIsPrimary'];
            $newWebsite->added_by = session()->get('user_id');
            $newWebsite->save();
            return $newWebsite;
        }
    }

    /**
     * @param $request
     * @return mixed
     */
    public function deleteWebsite($request): mixed
    {
        return CompanyWebsite::where('company_website_id', $request['company_website_id'])->delete();
    }

    /**
     * @return mixed
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function getSocialMedia(): mixed
    {
        return CompanySocialMedia::where('company_id', $this->getCompany()->company_id)->get();
    }

    /**
     * @param $request
     * @return CompanySocialMedia
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function saveOrUpdateSocialMedia($request): CompanySocialMedia
    {
        $socMed = CompanySocialMedia::where('key', $request['key'])->first();
        if ($socMed) {
            $socMed->social_media_name = $request['key'];
            $socMed->social_media_url = $request['value'];
            $socMed->key = $request['key'];
            $socMed->updated_by = session()->get('user_id');
            $socMed->save();
            return $socMed;
        } else {
            $newSoc = new CompanySocialMedia();
            $newSoc->company_id = $this->getCompany()->company_id;
            $newSoc->social_media_name = $request['key'];
            $newSoc->social_media_url = $request['value'];
            $newSoc->key = $request['key'];
            $newSoc->added_by = session()->get('user_id');
            $newSoc->save();
            return $newSoc;
        }
    }

    /**
     * @param $request
     * @return true
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function updateBusinessHours($request): bool
    {
        foreach($request as $key => $req) {
            $result = CompanyHours::where('day', $key)->where('company_id', $req['companyId'])->where('company_hours_id', $req['entryId'])->first();
            if($result) {
                $result->is_active = $req['isOn'];
                $result->start_time = $req['startTime'];
                $result->end_time = $req['endTime'];
                $result->updated_by = session()->get('user_id');
                $result->save();
            }
        }
        return true;
    }

    /**
     * @return mixed
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function getCompanyHours(): mixed
    {
        return CompanyHours::where('company_id', $this->getCompany()->company_id)->get();
    }

    /**
     * @param $request
     * @return mixed|void
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function saveCompanyBasicInfo($request)
    {
        $companyBasicInfo = $this->getCompany();
        if($companyBasicInfo) {
            $companyBasicInfo->company_name = $request['name'];
            $companyBasicInfo->industry = $request['industry'];
            $companyBasicInfo->license_number = $request['license'];
            $companyBasicInfo->federal_tax_id = $request['federalTaxId'];
            $companyBasicInfo->timezone = $request['timezone'];
            $companyBasicInfo->date_format = $request['dateFormatInfo'];
            $companyBasicInfo->time_format = $request['timeFormatInfo'];
            $companyBasicInfo->first_day = $request['dayWorkWeek'];
            $companyBasicInfo->logo_email_message = ($request['logo_email_message']=='true') ? 1 : 0;
            $companyBasicInfo->logo_client_portal = ($request['logo_client_portal']=='true') ? 1 : 0;
            $companyBasicInfo->logo_all_pdfs = ($request['logo_all_pdfs']=='true') ? 1 : 0;
            $companyBasicInfo->logo_financials = ($request['logo_financials']=='true') ? 1 : 0;
            $companyBasicInfo->save();

            if (isset($request['file'])) {
                
                $this->saveFile($companyBasicInfo->company_id, $request['file']);
            }
            return $companyBasicInfo;
        }
    }

    /**
     * @param $request
     * @return UserFileFolder
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     *
     */
    public function saveNewFolder($request): UserFileFolder
    {
        $fileFolderPath = 'User-File-Folder/'.session()->get('user_id').'/'.$request['folderName'].'/';
        $s3 = new S3Manager();
        $fileFolder = new UserFileFolder();
        $fileFolder->user_id = session()->get('user_id');
        $fileFolder->folder_name = $request['folderName'];
        $fileFolder->s3_path = $fileFolderPath;
        $fileFolder->added_from_page = $request['addedFrom'];
        $fileFolder->folder_desc = $request['desc'];
        $fileFolder->save();

        $s3->createFolder($fileFolderPath);
        return $fileFolder;
    }

    public function getPortfolioFolders()
    {
        $userFolderInfo = UserFileFolder::where('user_id', session()->get('user_id'))->where('added_from_page', 'portfolio')->get();
        $s3 = new S3Manager();
        foreach($userFolderInfo as $file) {
            $uploadFile = UserFileUpload::where('user_id', session()->get('user_id'))->where('folder_id', $file->file_folder_id)->where('page_from', 'portfolio')->latest('created_at')->first();
            if ($uploadFile) {
                $file->s3Url = $s3->getUrl($uploadFile->s3_path);
            }
        }

        return $userFolderInfo;
    }

    public function saveFolderName($request)
    {
        $folder = UserFileFolder::find($request['folder-id']);
        $folder->folder_name = $request['new-folder-name'];
        $folder->folder_desc = $request['folder-desc'] ?? $folder->folder_desc;
        $folder->save();

        return $folder;
    }

    public function savePortFolioFiles($request)
    {
        dd($request);
    }

    public function getPortfolioFilesWithFolder($request)
    {
        return UserFileUpload::leftJoin('users_file_folder', function($join) {
            $join->on('users_file_upload.folder_id', '=', 'users_file_folder.file_folder_id');
        })->where('users_file_upload.folder_id', '=', $request)->get();
    }

    public function getPortFolioFolderInfo($request)
    {
        return UserFileFolder::where('user_id', session()->get('user_id'))->where('file_folder_id', $request)->first();
    }

    /**
     * @return mixed
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    private function getCompany(): mixed
    {
        $company =  Company::where('user_id', session()->get('user_id'))->first();
        if ($company) {
            return $company;
        } else {
            return [];
        }
    }

    private function saveFile($companyId, $file): void
    {
        $s3KeyFileName = 'company/fileupload/'.$companyId.'/'.$file->getClientOriginalName();
        $fileUpload = new CompanyFileUpload();
        $fileUpload->company_id = $companyId;
        $fileUpload->file_name = $file->getClientOriginalName();
        $fileUpload->file_type = $file->getClientOriginalExtension();
        $fileUpload->s3_path = $s3KeyFileName;
        $fileUpload->save();

        $s3 = new S3Manager();
        $s3->store($file, $s3KeyFileName);
    }
}