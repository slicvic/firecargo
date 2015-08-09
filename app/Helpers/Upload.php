<?php namespace App\Helpers;

use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\File;

/**
 * Upload
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Upload {

    /**
     * Maximum upload file size in KB.
     *
     * @var int
     */
    const MAX_FILE_SIZE = 10000;

    /**
     * The upload directory root path.
     *
     * @var string
     */
    const ROOT_PATH = '/uploads/';

    /**
     * Resource paths.
     *
     * @var array
     */
    private static $resources = [
        'user' => [
            'profile_photo' => 'users/{{OWNER_ID}}/profile_photo/'
        ],
        'company' => [
            'logo'  => 'companies/{{OWNER_ID}}/logo/'
        ]
    ];

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
        $destination = self::resourcePath('user.profile_photo', $userId);

        File::exists($destination) OR File::makeDirectory($destination, 0775, TRUE);

        // Generate thumbnails
        $dimensions = [
            'sm' => 48,
            'md' => 200
        ];

        foreach ($dimensions as $filename => $dimension)
        {
            Image::make($file->getPathName())
                ->orientate()
                ->fit($dimension, $dimension)
                ->encode('png', 100)
                ->save("{$destination}{$filename}.png");
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
        $destination = self::resourcePath('company.logo', $companyId);

        File::exists($destination) OR File::makeDirectory($destination, 0775, TRUE);

        // Generate thumbnails
        $dimensions = [
            'sm' => 100,
            'md' => 200,
            'lg' => 300
        ];

        foreach ($dimensions as $filename => $dimension)
        {
            $image = Image::make($file->getPathName())
                ->orientate()
                ->fit($dimension, NULL, function($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

            $image->encode('png', 100)->save("{$destination}{$filename}.png");
            $image->encode('jpg', 100)->save("{$destination}{$filename}.jpg");
        }

        // Remove temp file
        unlink($file->getPathName());
    }

    /**
     * Gets the path to a resource folder.
     *
     * @see    Upload::$resources
     *
     * @param  string  $key       The resource key e.g. "user.profile_photo"
     * @param  string  $filename  A filename e.g. "sm.png"
     * @return string
     */
    private static function resourcePath($key, $ownerId)
    {
        $keyParts = explode('.', $key);

        $path = public_path() . self::ROOT_PATH;
        $path .= str_replace('{{OWNER_ID}}', $ownerId, self::$resources[$keyParts[0]][$keyParts[1]]);

        return $path;
    }

    /**
     * Gets the url to a resource.
     *
     * @see    Upload::$resources
     *
     * @param  string  $key       The resource key e.g. "user.profile_photo"
     * @param  string  $filename  A filename e.g. "sm.png"
     * @param  int     $ownerId   The entity ID to which the resource is attached.
     * @return string
     */
    public static function resourceUrl($key, $filename, $ownerId)
    {
        $keyParts = explode('.', $key);

        $path = self::ROOT_PATH;
        $path .= str_replace('{{OWNER_ID}}', $ownerId, self::$resources[$keyParts[0]][$keyParts[1]]);
        $path .= $filename . '?cb=' . time();

        return url($path);
    }

    /**
     * Checks if a resource exists or not.
     *
     * @see    Upload::$resources
     *
     * @param  string  $key       The resource key e.g. "user.profile_photo"
     * @param  string  $filename  A filename e.g. "sm.png"
     * @param  int     $ownerId   A user or company ID.
     * @return bool
     */
    public static function resourceExists($key, $filename, $ownerId)
    {
        $keyParts = explode('.', $key);

        $path = public_path() . self::ROOT_PATH;
        $path .= str_replace('{{OWNER_ID}}', $ownerId, self::$resources[$keyParts[0]][$keyParts[1]]);
        $path .= $filename;

        return File::exists($path);
    }
}
