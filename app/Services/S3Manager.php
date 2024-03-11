<?php

namespace App\Services;

use Aws\Exception\AwsException;
use Aws\S3\S3Client;

class S3Manager
{
    /**
     * @param $file
     * @param $pathDirectory
     * @return array
     */
    public function store($file, $pathDirectory = null): array
    {
        // If the file needs to be in a sub-folder
        /*$fullPath = $pathDirectory ? $pathDirectory.'/'.$file->file->getClientOriginalName() : $file->file->getClientOriginalName();*/

        try {
            $result = $this->s3Credentials()->putObject([
                'Bucket' => env('AWS_BUCKET'),
                'Key'    => $pathDirectory,
                'Body'   => fopen($file->getPathname(), 'r'),
                'ACL'    => 'public-read',
            ]);

            return ['success' => true, 'result' => $result];

        } catch (AwsException $e) {
            return ['success' => false, 'result' => $e->getMessage()];
        }
    }

    /**
     * @param $key
     * @return bool
     */
    public function checkIfExist($key): bool
    {
        try {
            $this->s3Credentials()->headObject([
                'Bucket' => env('AWS_BUCKET'),
                'Key'    => $key,
            ]);

            return true;
        } catch (Aws\S3\Exception\NoSuchKeyException $e) {
            return false;
        } catch (Aws\S3\Exception\S3Exception $e) {
            return false;
        }
    }

    /**
     * @param $key
     * @return mixed
     */
    public function getUrl($key): mixed
    {
        return $this->s3Credentials()->getObjectUrl(env('AWS_BUCKET'), $key);
    }

    /**
     * @param $key
     * @return string
     */
    public function downloadFile($key): string
    {
        $command = $this->s3Credentials()->getCommand('GetObject', [
            'Bucket' => env('AWS_BUCKET'),
            'Key' => $key
        ]);

        $request = $this->s3Credentials()->createPresignedRequest($command, '+10 minutes');

        return (string) $request->getUri();
    }

    public function preview($key)
    {
        try {
            // Generate a pre-signed URL for the image
            $cmd = $this->s3Credentials()->getCommand('GetObject', [
                'Bucket' => env('AWS_BUCKET'),
                'Key'    => $key,
            ]);

            $request = $this->s3Credentials()->createPresignedRequest($cmd, '+5 minutes');
            header('Content-Type: image/jpeg');
            return (string) $request->getUri();

        } catch (AwsException $e) {

            return $e->getMessage();
        }
    }

    /**
     * @param $key
     * @return true|void
     */
    public function delete($key)
    {
        try {
            $this->s3Credentials()->deleteObject([
                'Bucket' => env('AWS_BUCKET'),
                'Key'    => $key,
            ]);
            return true;
        } catch (S3Exception $e) {
            echo $e->getMessage() . "\n";
        }
    }

    public function getFileContents($key): array
    {
        try {

            $result = $this->s3Credentials()->getObject([
                    'Bucket' => env('AWS_BUCKET'),
                    'Key'    => $key,
            ]);

            // Get the body contents from the response result.
            $contents = $result['Body'];
            // Get the content type from the response result.
            $type = $result['ContentType'];

            // return the function with the file contents and file content type.
            return ['contents' => $contents, 'contentType' => $type, 'exists' => true];
        } catch (\Exception $ex) {
            // return the function with the empty file contents and file content type.
            return ['contents' => '', 'contentType' => '', 'exists' => false];
        }
    }

    /**
     * @param $folderKey
     * @return array
     */
    public function createFolder($folderKey): array
    {
        try {
            $result = $this->s3Credentials()->putObject([
                'Bucket' => env('AWS_BUCKET'),
                'Key'    => $folderKey,
                'Body'   => '',
            ]);

            return ['success' => true, 'result' => $result];

        } catch (AwsException $e) {
            return ['success' => false, 'result' => $e->getMessage()];
        }
    }

    /**
     * @return S3Client
     */
    public function s3Credentials(): S3Client
    {
        return S3Client::factory([
            'credentials' => [
                'key'    => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
            'region' => env('AWS_DEFAULT_REGION'),
            'version' => 'latest',
        ]);
    }
}