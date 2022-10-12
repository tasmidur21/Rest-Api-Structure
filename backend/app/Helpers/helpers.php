<?php

use App\Models\User;
use Hsnbd\AuditLogger\Classes\AuditLogProcessor;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

if (!function_exists('setting')) {
    function setting($key, $default = null)
    {
        return TCG\Voyager\Facades\Voyager::setting($key, $default);
    }
}

if (!function_exists('isProduction')) {
    function isProduction(): bool
    {
        return env('APP_ENV', 'local') === "production";
    }
}

if (!function_exists('menu')) {
    function menu($menuName, $type = null, array $options = [])
    {
        return TCG\Voyager\Facades\Voyager::model('Menu')->display($menuName, $type, $options);
    }
}

if (!function_exists('voyager_asset')) {
    function voyager_asset($path, $secure = null)
    {
        return route('voyager.voyager_assets') . '?path=' . urlencode($path);
    }
}

if (!function_exists('get_file_name')) {
    function get_file_name($name)
    {
        preg_match('/(_)([0-9])+$/', $name, $matches);
        if (count($matches) == 3) {
            return Illuminate\Support\Str::replaceLast($matches[0], '', $name) . '_' . (intval($matches[2]) + 1);
        } else {
            return $name . '_1';
        }
    }
}

if (!function_exists('getUserTypes')) {
    function getUserTypes(string $for = User::NORMAL_USER)
    {
        $userTypes = User::USER_TYPES;

        if ($for != User::SUPER_ADMIN) {
            unset($userTypes[User::SUPER_ADMIN]);
        }
        return $userTypes ?? [];
    }
}

if (!function_exists('getFormattedUserTypes')) {
    function getFormattedUserTypes(string $for = User::NORMAL_USER)
    {
        $userTypes = getUserTypes($for);
        if (!$userTypes) return [];

        return array_map(function ($type) {
            return Str::title(Str::replaceFirst('_', ' ', $type));
        }, $userTypes);
    }
}


if (!function_exists('bn2en')) {
    function bn2en($number)
    {
        $bn = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
        $en = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
        return str_replace($bn, $en, $number);
    }
}

if (!function_exists('en2bn')) {
    function en2bn($number)
    {
        $bn = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
        $en = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
        return str_replace($en, $bn, $number);
    }
}

if (!function_exists('localizedMenu')) {
    function localizedMenu($menuName, $type = null, array $options = [])
    {
        $localizedMenu = App\Facades\Voyager::model('Menu')->display($menuName, $type, $options);

        return $localizedMenu;
    }

    if (!function_exists('isCommonLocalKey')) {
        function isCommonLocalKey($key = null)
        {
            return !is_null($key) && in_array(Str::snake($key), config('voyager.common_local_keys'), true);
        }
    }
}

if (!function_exists('surveyTypeBn')) {
    function surveyTypeLabelBn($surveyNameEn)
    {
        $surveyName = '';
        $surveyName = \App\Models\KhotianIndexs::$surveyTypeLabel[$surveyNameEn];

        return $surveyName;
    }
}

if (!function_exists('generateHash')) {
    function generateHash()
    {
        // generating 6 digit unique hash
        $hash = rand(111, 999) . uniqid() . rand(111, 999);

        return $hash;
    }
}

if (!function_exists('countHolidays')) {
    function countHolidays($startDate, $endDate)
    {
        $totalHolidays = \App\Models\Holiday::whereBetween('calendar_date', [$startDate, $endDate])
            ->where('holiday', '!=', null)
            ->count();

        return $totalHolidays;
    }
}

if (!function_exists('getNextWorkingDay')) {
    function getNextWorkingDay($startDate)
    {
        $nextWorkingDay = \App\Models\Holiday::where('calendar_date', $startDate)->first();

        if ($nextWorkingDay && $nextWorkingDay->holiday != null) {
            return getNextWorkingDay(\Carbon\Carbon::parse($nextWorkingDay->calendar_date)->addDays(1));
        }

        return $nextWorkingDay->calendar_date;
    }
}
if (!function_exists('logPayment')) {
    function logPayment($message, $districtBBS = null, $type = 1, $messageType = 1)
    {
        $paymentLogPath = storage_path() . '/logs/payments/';

        if (!File::exists($paymentLogPath)) {
            File::makeDirectory($paymentLogPath, $mode = 0777, true, true);
        }

        if (!File::exists($paymentLogPath . 'online_payment/')) {
            File::makeDirectory($paymentLogPath . 'online_payment/', $mode = 0777, true, true);
        }
        if (!File::exists($paymentLogPath . 'certified_payment/')) {
            File::makeDirectory($paymentLogPath . 'certified_payment/', $mode = 0777, true, true);
        }

        if (!empty($districtBBS)) {
            $paymentLogPath = storage_path() . '/logs/payments/certified_payment/' . $districtBBS;
            if (!File::exists($paymentLogPath)) {
                File::makeDirectory($paymentLogPath, $mode = 0777, true, true);
            }
        }

        if ($type == 2) {
            $paymentLabel = 'logs/payments/certified_payment/' . $districtBBS . '/certified-payment';
        } else {
            $paymentLabel = 'logs/payments/online_payment/online-payment';
        }

        config(['logging.channels.online_payments.path' => storage_path($paymentLabel . '.log')]);

        switch ($messageType) {
            case 1:
                Log::channel('online_payments')->info($message);
                break;
            case 2:
                Log::channel('online_payments')->warning($message);
                break;
            case 3:
                Log::channel('online_payments')->critical($message);
                break;
            case 4:
                Log::channel('online_payments')->debug($message);
                break;
            default:
                Log::channel('online_payments')->notice($message);
                break;
        }
    }
}
if (!function_exists('ipnResponseLog')) {
    function ipnResponseLog($message, $messageType = 1)
    {
        $paymentLogPath = storage_path() . '/logs/ipn_response/';

        if (!File::exists($paymentLogPath)) {
            File::makeDirectory($paymentLogPath, $mode = 0777, true, true);
        }

        config(['logging.channels.online_payments.path' => storage_path('logs/ipn_response/ipn-response.log')]);

        switch ($messageType) {
            case 1:
                Log::channel('online_payments')->info($message);
                break;
            case 2:
                Log::channel('online_payments')->warning($message);
                break;
            case 3:
                Log::channel('online_payments')->critical($message);
                break;
            case 4:
                Log::channel('online_payments')->debug($message);
                break;
            default:
                Log::channel('online_payments')->notice($message);
                break;
        }
    }
}
if (!function_exists('ipnLog')) {
    function ipnLog($message, $districtBBS = null, $type = 1, $messageType = 1)
    {
        $paymentLogPath = storage_path() . '/logs/ekpay/';

        if (!File::exists($paymentLogPath)) {
            File::makeDirectory($paymentLogPath, $mode = 0777, true, true);
        }

        if (!File::exists($paymentLogPath . 'online_payment/')) {
            File::makeDirectory($paymentLogPath . 'online_payment/', $mode = 0777, true, true);
        }
        if (!File::exists($paymentLogPath . 'certified_payment/')) {
            File::makeDirectory($paymentLogPath . 'certified_payment/', $mode = 0777, true, true);
        }

        if (!empty($districtBBS)) {
            $paymentLogPath = storage_path() . '/logs/ekpay/certified_payment/' . $districtBBS;
            if (!File::exists($paymentLogPath)) {
                File::makeDirectory($paymentLogPath, $mode = 0777, true, true);
            }
        }

        if ($type == 2) {
            $paymentLabel = 'logs/ekpay/certified_payment/' . $districtBBS . '/certified-payment';
        } else {
            $paymentLabel = 'logs/ekpay/online_payment/online-payment';
        }

        config(['logging.channels.online_payments.path' => storage_path($paymentLabel . '.log')]);

        switch ($messageType) {
            case 1:
                Log::channel('online_payments')->info($message);
                break;
            case 2:
                Log::channel('online_payments')->warning($message);
                break;
            case 3:
                Log::channel('online_payments')->critical($message);
                break;
            case 4:
                Log::channel('online_payments')->debug($message);
                break;
            default:
                Log::channel('online_payments')->notice($message);
                break;
        }

    }
}
if (!function_exists('cliLog')) {
    function cliLog($message, $messageType = 1, $customPath = 'cli-log.log')
    {
        $cliLog = storage_path() . '/logs/';

        if (!File::exists($cliLog)) {
            File::makeDirectory($cliLog, $mode = 0777, true, true);
        }

        config(['logging.channels.cli_log.path' => storage_path('logs/' . $customPath)]);

        switch ($messageType) {
            case 1:
                Log::channel('cli_log')->info($message);
                break;
            case 2:
                Log::channel('cli_log')->warning($message);
                break;
            case 3:
                Log::channel('cli_log')->critical($message);
                break;
            case 4:
                Log::channel('cli_log')->debug($message);
                break;
            default:
                Log::channel('cli_log')->notice($message);
                break;
        }
    }
}
if (!function_exists('upayLog')) {
    function upayLog($message, $messageType = 1)
    {
        $cliLog = storage_path() . '/logs/';

        if (!File::exists($cliLog)) {
            File::makeDirectory($cliLog, $mode = 0777, true, true);
        }

        config(['logging.channels.upay_log.path' => storage_path('logs/upay-log.log')]);

        switch ($messageType) {
            case 1:
                Log::channel('upay_log')->info($message);
                break;
            case 2:
                Log::channel('upay_log')->warning($message);
                break;
            case 3:
                Log::channel('upay_log')->critical($message);
                break;
            case 4:
                Log::channel('upay_log')->debug($message);
                break;
            default:
                Log::channel('upay_log')->notice($message);
                break;
        }
    }
}
if (!function_exists('processor')) {
    function processor($data, $eventName)
    {
        $auditLogProcessor = new AuditLogProcessor();
        $auditLogProcessor->model = $data;
        $auditLogProcessor->modelActionType = $eventName;

        return $auditLogProcessor;
    }
}


if (!function_exists('encrypt')) {
    function encrypt($data)
    {
        $key = 'l<╠bU!f\x12¹═Å%û"\t?9ïâ\x04Xîì\x05ƒNé\x04²Q¼Å';
        return Defuse\Crypto\Crypto::encrypt($data, $key);
    }
}
if (!function_exists('decrypt')) {
    function decrypt($data)
    {
        $key = 'l<╠bU!f\x12¹═Å%û"\t?9ïâ\x04Xîì\x05ƒNé\x04²Q¼Å';
        return Defuse\Crypto\Crypto::decrypt($data, $key);
    }
}

if (!function_exists('isMobile')) {
    function isMobile($mobileNumber)
    {
        $validCheckPattern = "/^(?:\+88|01)?(?:\d{11}|\d{13})$/";
        if (preg_match($validCheckPattern, $mobileNumber)) {
            return true;
        }

        return false;
    }
}

if (!function_exists('generateHashCode')) {
    function generateHashCode()
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0C2f) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0x2Aff), mt_rand(0, 0xffD3), mt_rand(0, 0xff4B)
        );

    }
}

if (!function_exists('en2bnDate')) {
    function en2bnDate($date)
    {
        $date = \Carbon\Carbon::parse($date)->format('M Y');
        $month = substr($date, 0, 3);
        $year = substr($date, -4);

        $monthBn = '';
        $yearBn = en2bn($year);

        switch ($month) {
            case 'Jan':
                $monthBn = 'জানুয়ারি';
                break;
            case 'Feb':
                $monthBn = 'ফেব্রুয়ারি';
                break;
            case 'Mar':
                $monthBn = 'মার্চ';
                break;
            case 'Apr':
                $monthBn = 'এপ্রিল';
                break;
            case 'May':
                $monthBn = 'মে';
                break;
            case 'Jun':
                $monthBn = 'জুন';
                break;
            case 'Jul':
                $monthBn = 'জুলাই';
                break;
            case 'Aug':
                $monthBn = 'আগস্ট';
                break;
            case 'Sep':
                $monthBn = 'সেপ্টেম্বর';
                break;
            case 'Oct':
                $monthBn = 'অক্টবর';
                break;
            case 'Nov':
                $monthBn = 'নভেম্বর';
                break;
            case 'Dec':
                $monthBn = 'ডিসেম্বর';
                break;
            default:
                $monthBn = 'জানুয়ারি';
                break;
        }

        $yearMonth = $monthBn . ' ' . $yearBn;
        return $yearMonth;
    }

    if (!function_exists('styleRed')) {
        function styleRed($string)
        {
            return "\033[31m$string\033[0m";
        }
    }
    if (!function_exists('styleGreen')) {
        function styleGreen($string)
        {
            return "\033[32m$string\033[0m";
        }
    }
    if (!function_exists('styleLightGreen')) {
        function styleLightGreen($string)
        {
            return "\033[32m$string\033[0m ";
        }
    }
    if (!function_exists('stylePurple')) {
        function stylePurple($string)
        {
            return "\033[35m$string\033[0m";
        }
    }
    if (!function_exists('styleYellow')) {
        function styleYellow($string)
        {
            return "\033[33m$string\033[0m";
        }
    }
}

if (!function_exists('en2bnDateFormat')) {
    function en2bnDateFormat($date)
    {
        $engDATE = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '0', 'January', 'February', 'March', 'April',
            'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December', 'Saturday', 'Sunday',
            'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday');
        $bangDATE = array('১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯', '০', 'জানুয়ারী', 'ফেব্রুয়ারী', 'মার্চ', 'এপ্রিল', 'মে',
            'জুন', 'জুলাই', 'আগস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর', 'শনিবার', 'রবিবার', 'সোমবার', 'মঙ্গলবার', 'বুধবার', 'বৃহস্পতিবার', 'শুক্রবার'
        );
        $convertedDATE = str_replace($engDATE, $bangDATE, $date);
        return "$convertedDATE";
    }
}

if (!function_exists('eng_to_bangla_to_english_code_updated')) {
    function eng_to_bangla_to_english_code_updated($input)
    {
        $ban_number = array('১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯', '০', '');
        $eng_number = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 0, '');

        if (in_array($input, $ban_number)) {
            $input = bn2en($input);
        }
        return str_replace($eng_number, $ban_number, $input);
    }
}

if (!function_exists('responseBuilder')) {

    /**
     * @param int|string $statusCode
     * @param string $message
     * @param $responseDataOrError
     * @return array
     */
    function responseBuilder(int|string $statusCode, string $message, $responseDataOrError = []): array
    {
        $successCodes = range(200, 206);
        $response['status_code'] = $statusCode;
        $response['message'] = $message;;

        if (in_array($statusCode, $successCodes)) {
            $response['data'] = $responseDataOrError;
        } else {
            $response['errors'] = $responseDataOrError;
        }
        return $response;
    }
}


