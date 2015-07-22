<?php namespace App\Helpers;

use Intervention\Image\ImageManagerStatic as Image;

/**
 * Upload
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Upload {

    /**
     * Upload root path.
     */
    const ROOT_PATH = '/uploads/';

    /**
     * Max upload file size in KB.
     *
     * @var int
     */
    const MAX_FILE_SIZE = 10000;

    /**
     * Saves a user profile photo.
     *
     * @param  UploadedFile  $file
     * @param  int           $userId
     * @return void
     * @throws Exception
     */
    public static function saveUserProfilePhoto($file, $userId)
    {
        // Create destination directory

        $destination = self::getUserProfilePhotoBasePath($userId);

        if ( ! file_exists($destination))
        {
            mkdir($destination, 0775, TRUE);
        }

        // Generate thumbnails

        $dimensions = [
            'sm' => 48,
            'md' => 200
        ];

        foreach ($dimensions as $filename => $dimension)
        {
            $filename .= '.png';

            Image::make($file->getPathName())
                ->orientate()
                ->resize($dimension, $dimension)
                ->save($destination . $filename);
        }

        // Remove temp file

        unlink($file->getPathName());
    }

    /**
     * Saves a company loho.
     *
     * @param  UploadedFile  $file
     * @param  int           $companyId
     * @return void
     * @throws Exception
     */
    public static function saveCompanyLogo($file, $companyId)
    {
         // Create destination directory

        $destination = self::getCompanyLogoBasePath($companyId);

        if ( ! file_exists($destination))
        {
            mkdir($destination, 0775, TRUE);
        }

        // Generate thumbnails

        $dimensions = [
            'sm' => 100,
            'md' => 200,
            'lg' => 300
        ];

        foreach ($dimensions as $filename => $dimension)
        {
            $filename .= '.png';

            Image::make($file->getPathName())
                ->orientate()
                ->resize($dimension, NULL, function($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save($destination . $filename);
        }

        // Remove temp file

        unlink($file->getPathName());
    }

    /**
     * Gets the base path of a user's profile photo.
     *
     * @param  int  $userId
     * @return string
     */
    public static function getUserProfilePhotoBasePath($userId)
    {
        return public_path() . self::getUserProfilePhotoRootPath($userId);
    }

    /**
     * Gets the root path of a user's profile photo.
     *
     * @param  int  $userId
     * @return string
     */
    public static function getUserProfilePhotoRootPath($userId)
    {
        return self::ROOT_PATH . 'users/' . $userId . '/images/profile/';
    }

    /**
     * Gets the URL of a user's profile photo.
     *
     * @param  User    $user
     * @param  string  $size  sm|md
     * @return string
     */
    public static function getUserProfilePhotoURL($user, $size)
    {
        if ( ! $user->has_photo)
        {
            return asset('assets/admin/img/avatar.png');
        }

        $filename = $size . '.png';

        return asset(self::getUserProfilePhotoRootPath($user->id) . $filename) . '?cb=' . time();
    }

    /**
     * Gets the base path of a company's logo.
     *
     * @param  int  $companyId
     * @return string
     */
    public static function getCompanyLogoBasePath($companyId)
    {
        return public_path() . self::getCompanyLogoRootPath($companyId);
    }

    /**
     * Gets the root path of a company's logo.
     *
     * @param  int  $companyId
     * @return string
     */
    public static function getCompanyLogoRootPath($companyId)
    {
        return self::ROOT_PATH . 'companies/' . $companyId . '/images/logo/';
    }

    /**
     * Gets the URL of a company's logo.
     *
     * @param  Company  $company
     * @param  string   $size  sm|md|lg
     * @return string
     */
    public static function getCompanyLogoURL($company, $size)
    {
        if ( ! $company->has_logo)
        {
            return asset('assets/admin/img/avatar.png');
        }

        $filename = $size . '.png';

        return asset(self::getCompanyLogoRootPath($company->id) . $filename) . '?cb=' . time();
    }

}
