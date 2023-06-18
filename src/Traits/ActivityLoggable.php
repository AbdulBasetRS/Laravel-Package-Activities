<?php 

namespace Abdulbaset\Activities\Traits;

use Abdulbaset\Activities\Models\ActivityLog;
// use Illuminate\Http\Request;
use Carbon\Carbon;

trait ActivityLoggable
{
    
    protected static $crud = [
        'create' => true,
        'read' => true,
        'update' => true,
        'delete'=> true ,
    ];
    
    protected static $operation_info = [
        'ip' => true,
        'browser' => true,
        'browser_version' => true,
        'referring_url' => true ,
        'current_url' => true ,
        'device_type' => true ,
        'operating_system'=> true 
    ];
    
    protected static $exclude = [];

    public static function setExclude(array $exclude){
        self::$exclude = $exclude;
    }

    public static function getExclude(){
        return array_merge(self::$exclude , config('ActivityConfig.exclude_column'));
    }

    protected static function getUserId(){
        if (auth()->check()) {
            $output = auth()->id();
        } else {

        }
        return $output;
    }

    private static function isAllowed($args) {
        if (in_array($args, self::$crud)) {
            return self::$crud[$args];
        }
        return true;
    }

    private static function isAllowedCRUD($arg) {
        if (config('ActivityConfig.crud_operation.'.$arg) == false) {
            return false;
        }
        if (array_key_exists($arg, self::$crud)) {
            return self::$crud[$arg];
        }
        return true;
    }
    
    private static function isAllowedOperationInfo($arg) {
        if (config('ActivityConfig.operation_info.'.$arg) == false) {
            return false;
        }
        if (array_key_exists($arg, self::$operation_info)) {
            return self::$operation_info[$arg];
        }
        return true;
    }

    private static  function getIp() {
        $ip = null;
        if (self::isAllowedOperationInfo('ip') == false){
            return $ip;
        }

        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED'];
        } elseif (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_FORWARDED'])) {
            $ip = $_SERVER['HTTP_FORWARDED'];
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }else {
            $ip = 'Unknown';
        }
        return $ip;
    }

    private static function getBrowser() {
        $browser = null;
        if (self::isAllowedOperationInfo('browser') == false){
            return $browser;
        }
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        if (preg_match('/msie/i', $user_agent) && !preg_match('/opera/i', $user_agent)) {
            $browser = 'Internet Explorer';
        } elseif (preg_match('/firefox/i', $user_agent)) {
            $browser = 'Firefox';
        } elseif (preg_match('/chrome/i', $user_agent)) {
            $browser = 'Chrome';
        } elseif (preg_match('/safari/i', $user_agent)) {
            $browser = 'Safari';
        } elseif (preg_match('/opera/i', $user_agent)) {
            $browser = 'Opera';
        } else {
            $browser = 'Unknown';
        }
        return $browser;
    }

    private static function getBrowserVersion() {
        $browser_version = null;
        if (self::isAllowedOperationInfo('browser_version') == false){
            return $browser_version;
        }
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $pattern = '/(?P<browser>Firefox|Chrome|Safari|Opera|MSIE|Trident[^;]+).*?((?P<version>\d+[\w\.]*).*)?$/i';
        if (preg_match($pattern, $user_agent, $matches)) {
            $browser_version = isset($matches['version']) ? $matches['version'] : '';
        }else {
            $browser_version = 'Unknown';
        }
        return $browser_version;
    }

    private static function getReferringURL() {
        $referring_url = null;
        if (self::isAllowedOperationInfo('referring_url') == false){
            return $referring_url;
        }
        if (isset($_SERVER['HTTP_REFERER'])) {
            $referring_url = $_SERVER['HTTP_REFERER'];
        } else {
            $referring_url = 'Unknown';
        }
        return $referring_url;
    }

    private static function getCurrentURL() {
        $current_url = null;
        if (self::isAllowedOperationInfo('current_url') == false){
            return $current_url;
        }
        $current_url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        return $current_url;
    }

    private static function getDeviceType() {
        $device_type = null;
        if (self::isAllowedOperationInfo('device_type') == false){
            return $device_type;
        }

        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        if (strpos($user_agent, 'Mobile') !== false || strpos($user_agent, 'Android') !== false || strpos($user_agent, 'iPhone') !== false || strpos($user_agent, 'iPad') !== false || strpos($user_agent, 'iPod') !== false) {
            $device_type = 'Mobile';
        } elseif (strpos($user_agent, 'Tablet') !== false || strpos($user_agent, 'iPad') !== false || strpos($user_agent, 'Android') !== false) {
            $device_type = 'Tablet';
        } else {
            $device_type = 'Desktop';
        }
        return $device_type;
    }

    private static function getOperatingSystem(){
        $operating_system = null;
        if (self::isAllowedOperationInfo('operating_system') == false){
            return $operating_system;
        }
        $operating_system = "Unknown";
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $os_array = array(
            '/windows nt 10/i'      =>  'Windows 10',
            '/windows nt 6.3/i'     =>  'Windows 8.1',
            '/windows nt 6.2/i'     =>  'Windows 8',
            '/windows nt 6.1/i'     =>  'Windows 7',
            '/windows nt 6.0/i'     =>  'Windows Vista',
            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
            '/windows nt 5.1/i'     =>  'Windows XP',
            '/windows xp/i'         =>  'Windows XP',
            '/windows nt 5.0/i'     =>  'Windows 2000',
            '/windows me/i'         =>  'Windows ME',
            '/win98/i'              =>  'Windows 98',
            '/win95/i'              =>  'Windows 95',
            '/win16/i'              =>  'Windows 3.11',
            '/macintosh|mac os x/i' =>  'Mac OS X',
            '/mac_powerpc/i'        =>  'Mac OS 9',
            '/linux/i'              =>  'Linux',
            '/ubuntu/i'             =>  'Ubuntu',
            '/iphone/i'             =>  'iPhone OS',
            '/ipod/i'               =>  'iPod OS',
            '/ipad/i'               =>  'iPad OS',
            '/android/i'            =>  'Android',
            '/blackberry/i'         =>  'BlackBerry',
            '/webos/i'              =>  'Mobile'
        );
        foreach ($os_array as $regex => $value) {
            if (preg_match($regex, $user_agent)) {
                $operating_system = $value;
                break;
            }
        }
        return $operating_system ;
    }

    protected function addExcludeCoulmn($keys){
        $exclude = static::$exclude;
        $exclude = array_merge($exclude, $keys);
        static::$exclude = array_unique($exclude);
    }

    private static function exclude($value) {
        return array_diff_key($value, array_flip(self::getExclude()));
    }

    private static function format($model,$dates = []){
        $dates_type = [];
        $data = [];
        foreach ($dates as $key => $value) {
            $dates_type[] = $value;
        }

        foreach ($model as $key => $value) {
            if (in_array($key,$dates_type)) {
                $data[$key] = Carbon::parse($value)->format('Y-m-d H:i:s');
                continue;
            }
            $data[$key] = $value;
        }
        return $data;
    }

    private static function customArrayDiff($array1,$array2){
        $keyArray2 = [];
        $data = [];
        foreach ($array2 as $key => $value) {
            $keyArray2[] = $key;
        }
        foreach ($array1 as $key => $value) {
            if (!in_array($key,$keyArray2)) {
                continue;
            }
            if ($value !== $array2[$key]) {
                $data[$key] = $value;
            }
        }
        return $data;
    }

    public static function bootActivityLoggable(){
        static::created(function ($model) {
            if (self::isAllowedCRUD('create') == false) {
                return ;
            }
            $new = self::exclude(self::format($model->getAttributes(),$model->getDates()));
            if ($new == null) {
                return ;
            }
            $activity = new ActivityLog([
                'event' => 'create',
                'user_id' => self::getUserId(),
                'model' => get_class($model),
                'model_id' => $model->id,
                'old' => null,
                'new' => json_encode($new),
                'ip' => self::getIp(),
                'browser' => self::getBrowser(),
                'browser_version' => self::getBrowserVersion(),
                'referring_url' => self::getReferringURL(),
                'current_url' => self::getCurrentURL(),
                'device_type' => self::getDeviceType(),
                'operating_system' => self::getOperatingSystem(),
                'description' => null,
            ]);
            $model->activities()->save($activity);
        });

        static::updated(function ($model) {
            if (self::isAllowedCRUD('update') == false) {
                return ;
            }
            $original = self::exclude(self::format($model->getOriginal(),$model->getDates()));
            $updated = self::exclude(self::format($model->getAttributes(),$model->getDates()));
            $new = self::customArrayDiff($updated, $original);
            $old = self::customArrayDiff($original, $updated);
            if ($new == null AND $old == null) {
                return ;
            }
            $activity = new ActivityLog([
                'event' => 'update',
                'user_id' => self::getUserId(),
                'model' => get_class($model),
                'model_id' => $model->id,
                'old' => json_encode($old),
                'new' => json_encode($new),
                'ip' => self::getIp(),
                'browser' => self::getBrowser(),
                'browser_version' => self::getBrowserVersion(),
                'referring_url' => self::getReferringURL(),
                'current_url' => self::getCurrentURL(),
                'device_type' => self::getDeviceType(),
                'operating_system' => self::getOperatingSystem(),
                'description' => null,
            ]);
            $model->activities()->save($activity);
        });

        static::deleted(function ($model) {
            if (self::isAllowedCRUD('delete') == false) {
                return ;
            }
            $old = self::exclude(self::format($model->getOriginal(),$model->getDates()));
            if ($old == null) {
                return ;
            }
            $activity = new ActivityLog([
                'event' => 'delete',
                'user_id' => self::getUserId(),
                'model' => get_class($model),
                'model_id' => $model->id,
                'old' => json_encode($old),
                'new' => null,
                'ip' => self::getIp(),
                'browser' => self::getBrowser(),
                'browser_version' => self::getBrowserVersion(),
                'referring_url' => self::getReferringURL(),
                'current_url' => self::getCurrentURL(),
                'device_type' => self::getDeviceType(),
                'operating_system' => self::getOperatingSystem(),
                'description' => null,
            ]);
            $model->activities()->save($activity);
        });

        static::retrieved(function ($model) {
            if (self::isAllowedCRUD('read') == false) {
                return ;
            }
            $activity = new ActivityLog([
                'event' => 'read',
                'user_id' => self::getUserId(),
                'model' => get_class($model),
                'model_id' => $model->id,
                'old' => null,
                'new' => null,
                'ip' => self::getIp(),
                'browser' => self::getBrowser(),
                'browser_version' => self::getBrowserVersion(),
                'referring_url' => self::getReferringURL(),
                'current_url' => self::getCurrentURL(),
                'device_type' => self::getDeviceType(),
                'operating_system' => self::getOperatingSystem(),
                'description' => null
            ]);
            $model->activities()->save($activity);
        });
    }

    public static function setRecord($event,$description = null ) {
        $activity = new ActivityLog([
            'event' => $event,
            'user_id' => self::getUserId(),
            'model' => null,
            'model_id' => null,
            'old' => null,
            'new' => null,
            'ip' => self::getIp(),
            'browser' => self::getBrowser(),
            'browser_version' => self::getBrowserVersion(),
            'referring_url' => self::getReferringURL(),
            'current_url' => self::getCurrentURL(),
            'device_type' => self::getDeviceType(),
            'operating_system' => self::getOperatingSystem(),
            'description' => $description
        ]);
        $activity->save();
    } 

    public function activities(){
        return $this->hasMany(ActivityLog::class, 'model_id');
    }
}
