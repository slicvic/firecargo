<?php namespace App\Helpers;

use Intervention\Image\ImageManagerStatic as Image;

/**
 * Upload
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Upload {

    /**
     * @var string  The root upload directory path.
     */
    const ROOT_PATH = '/uploads/';

    /**
     * @var array  Resource paths.
     */
    private static $resources = [
        'profile_photo' => 'users/%ID%/images/profile/',
        'company_logo'  => 'companies/%ID%/images/logo/'
    ];

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

        $destination = self::resourcePath('profile_photo', $userId);

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
            Image::make($file->getPathName())
                ->orientate()
                ->resize($dimension, $dimension)
                ->save($destination . "{$filename}.png");
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

        $destination = self::resourcePath('company_logo', $companyId);

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
            Image::make($file->getPathName())
                ->orientate()
                ->resize($dimension, NULL, function($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save($destination . "{$filename}.png");
        }

        // Remove temp file

        unlink($file->getPathName());
    }

    /**
     * Gets the path to a resource folder.
     *
     * @param  string  $key  The resource name
     * @param  int     $id   The owner id
     * @return string
     * @see    Upload::$resources
     */
    private static function resourcePath($key, $id)
    {
        $path = public_path() . self::ROOT_PATH;
        $path .= str_replace('%ID%', $id, self::$resources[$key]);

        return $path;
    }

    /**
     * Gets the url to a resource.
     *
     * @param  string  $key       The resource name
     * @param  int     $id        The owner id
     * @param  string  $filename  The resource filename
     * @return string
     * @see    Upload::$resources
     */
    public static function resourceUrl($key, $id, $filename)
    {
        $path = self::ROOT_PATH;
        $path .= str_replace('%ID%', $id, self::$resources[$key]);
        $path .= $filename . '?cb=' . time();

        return url($path);
    }
}
