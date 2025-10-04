<?php

namespace App\Services\v1;

use App\Models\v1\ApplicationSetting;
use App\Models\v1\IdCardSetting;
use App\Models\v1\MailSetting;
use App\Models\v1\MarksheetSetting;
use App\Models\v1\PrintSetting;
use App\Models\v1\Setting;
use App\Models\v1\SocialSetting;
use App\Models\v1\SmsSetting;
use App\Models\v1\TaxSetting;
use App\Models\v1\TopbarSetting;
use App\Models\v1\ScheduleSetting;
use App\Traits\v1\EnvironmentVariable;
use App\Traits\v1\FileUploader;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * Settings Service - Version 1
 *
 * This service handles all settings-related operations including creation,
 * management, and retrieval of various system settings in the College Management System.
 *
 * @package App\Services\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class SettingsService
{
    use EnvironmentVariable, FileUploader;
    /*
    |--------------------------------------------------------------------------
    | Application Settings Methods
    |--------------------------------------------------------------------------
    |
    | These methods handle all application setting-related operations including
    | CRUD operations for application settings and application setting filtering.
    |
    */

    /**
     * Get application setting.
     *
     * @return ApplicationSetting
     */
    public function getApplicationSetting(): ApplicationSetting
    {
        return ApplicationSetting::first();
    }

    /**
     * Update or create an application setting.
     *
     * @param array $data
     * @return ApplicationSetting
     */
    public function updateOrCreateApplicationSetting(array $data): ApplicationSetting
    {
        return DB::transaction(function () use ($data) {
            $data['updated_by'] = auth()->id() ?? 1;
            return ApplicationSetting::updateOrCreate(['id' => 1], $data);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Mail Settings Methods
    |--------------------------------------------------------------------------
    |
    | These methods handle all mail setting-related operations including
    | CRUD operations for mail settings and mail setting filtering.
    |
    */

    /**
     * Get mail setting.
     *
     * @return MailSetting
     */
    public function getMailSetting(): MailSetting
    {
        return MailSetting::first();
    }

    /**
     * Update or create a mail setting.
     *
     * @param array $data
     * @return MailSetting
     */
    public function updateOrCreateMailSetting(array $data): MailSetting
    {
        return DB::transaction(function () use ($data) {
            $data['updated_by'] = auth()->id() ?? 1;
            $result = MailSetting::updateOrCreate(['id' => 1], $data);
            
            // Update environment variables
            $this->updateEnvVariable('MAIL_MAILER', '"' . ($data['driver'] ?? 'smtp') . '"');
            $this->updateEnvVariable('MAIL_HOST', '"' . ($data['host'] ?? 'localhost') . '"');
            $this->updateEnvVariable('MAIL_PORT', '"' . ($data['port'] ?? '587') . '"');
            $this->updateEnvVariable('MAIL_USERNAME', '"' . ($data['username'] ?? '') . '"');
            $this->updateEnvVariable('MAIL_PASSWORD', '"' . ($data['password'] ?? '') . '"');
            $this->updateEnvVariable('MAIL_ENCRYPTION', '"' . ($data['encryption'] ?? 'tls') . '"');
            $this->updateEnvVariable('MAIL_FROM_ADDRESS', '"' . ($data['sender_email'] ?? '') . '"');
            $this->updateEnvVariable('MAIL_FROM_NAME', '"' . ($data['sender_name'] ?? '') . '"');
            
            return $result;
        });
    }

    /*
    |--------------------------------------------------------------------------
    | ID Card Settings Methods
    |--------------------------------------------------------------------------
    |
    | These methods handle all ID card setting-related operations including
    | CRUD operations for ID card settings and ID card setting filtering.
    |
    */

    /**
     * Get ID card setting.
     *
     * @return IdCardSetting
     */
    public function getIdCardSetting(): IdCardSetting
    {
        return IdCardSetting::first();
    }

    /**
     * Update or create an ID card setting.
     *
     * @param array $data
     * @return IdCardSetting
     */
    public function updateOrCreateIdCardSetting(array $data): IdCardSetting
    {
        return DB::transaction(function () use ($data) {
            $data['updated_by'] = auth()->id() ?? 1;
            return IdCardSetting::updateOrCreate(['id' => 1], $data);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Marksheet Settings Methods
    |--------------------------------------------------------------------------
    |
    | These methods handle all marksheet setting-related operations including
    | CRUD operations for marksheet settings and marksheet setting filtering.
    |
    */

    /**
     * Get marksheet setting.
     *
     * @return MarksheetSetting
     */
    public function getMarksheetSetting(): MarksheetSetting
    {
        return MarksheetSetting::first();
    }

    /**
     * Update or create a marksheet setting.
     *
     * @param array $data
     * @return MarksheetSetting
     */
    public function updateOrCreateMarksheetSetting(array $data): MarksheetSetting
    {
        return DB::transaction(function () use ($data) {
            $data['updated_by'] = auth()->id() ?? 1;
            return MarksheetSetting::updateOrCreate(['id' => 1], $data);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Print Settings Methods
    |--------------------------------------------------------------------------
    |
    | These methods handle all print setting-related operations including
    | CRUD operations for print settings and print setting filtering.
    |
    */

    /**
     * Get print setting.
     *
     * @return PrintSetting
     */
    public function getPrintSetting(): PrintSetting
    {
        return PrintSetting::first();
    }

    /**
     * Update or create a print setting.
     *
     * @param array $data
     * @return PrintSetting
     */
    public function updateOrCreatePrintSetting(array $data): PrintSetting
    {
        return DB::transaction(function () use ($data) {
            $data['updated_by'] = auth()->id() ?? 1;
            
            // Get the filesystem disk for print settings
            $disk = $this->getPrintSettingsDisk();
            
            // Get existing print setting to check for existing images
            $existingSetting = PrintSetting::first();
            
            // Handle logo_left_file upload/update
            if (isset($data['logo_left_file']) && $data['logo_left_file']) {
                if ($existingSetting && $existingSetting->logo_left) {
                    // Update existing image
                    $data['logo_left'] = $this->updateImage(file: $data['logo_left_file'], directory: 'print-settings/logos', disk: $disk, width: 200, height: 200, maintainAspectRatio: true, fit: 'contain', model: $existingSetting, field: 'logo_left');
                } else {
                    // Upload new image
                    $data['logo_left'] = $this->uploadImage(file: $data['logo_left_file'], directory: 'print-settings/logos', disk: $disk, width: 200, height: 200, maintainAspectRatio: true, fit: 'contain');
                }
                unset($data['logo_left_file']);
            }
            
            // Handle logo_right_file upload/update
            if (isset($data['logo_right_file']) && $data['logo_right_file']) {
                if ($existingSetting && $existingSetting->logo_right) {
                    // Update existing image
                    $data['logo_right'] = $this->updateImage(file: $data['logo_right_file'], directory: 'print-settings/logos', disk: $disk, width: 200, height: 200, maintainAspectRatio: true, fit: 'contain', model: $existingSetting, field: 'logo_right');
                } else {
                    // Upload new image
                    $data['logo_right'] = $this->uploadImage(file: $data['logo_right_file'], directory: 'print-settings/logos', disk: $disk, width: 200, height: 200, maintainAspectRatio: true, fit: 'contain');
                }
                unset($data['logo_right_file']);
            }
            
            // Handle background_file upload/update
            if (isset($data['background_file']) && $data['background_file']) {
                if ($existingSetting && $existingSetting->background) {
                    // Update existing image
                    $data['background'] = $this->updateImage(file: $data['background_file'], directory: 'print-settings/backgrounds', disk: $disk, width: 800, height: 600, maintainAspectRatio: true, fit: 'contain', model: $existingSetting, field: 'background');
                } else {
                    // Upload new image
                    $data['background'] = $this->uploadImage(file: $data['background_file'], directory: 'print-settings/backgrounds', disk: $disk, width: 800, height: 600, maintainAspectRatio: true, fit: 'contain');
                }
                unset($data['background_file']);
            }
            
            return PrintSetting::updateOrCreate(['id' => 1], $data);
        });
    }

    /**
     * Get the filesystem disk for print settings.
     *
     * @return string
     */
    private function getPrintSettingsDisk(): string
    {
        return config('filesystems.print_settings_disk', 'public');
    }

    /*
    |--------------------------------------------------------------------------
    | Tax Settings Methods
    |--------------------------------------------------------------------------
    |
    | These methods handle all tax setting-related operations including
    | CRUD operations for tax settings and tax setting filtering.
    |
    */

    /**
     * Get tax setting.
     *
     * @return TaxSetting
     */
    public function getTaxSetting(): TaxSetting
    {
        return TaxSetting::first();
    }

    /**
     * Update or create a tax setting.
     *
     * @param array $data
     * @return TaxSetting
     */
    public function updateOrCreateTaxSetting(array $data): TaxSetting
    {
        return DB::transaction(function () use ($data) {
            $data['updated_by'] = auth()->id() ?? 1;
            return TaxSetting::updateOrCreate(['id' => 1], $data);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Schedule Settings Methods
    |--------------------------------------------------------------------------
    |
    | These methods handle all schedule setting-related operations including
    | CRUD operations for schedule settings and schedule setting filtering.
    |
    */

    /**
     * Get schedule setting.
     *
     * @return ScheduleSetting
     */
    public function getScheduleSetting(): ScheduleSetting
    {
        return ScheduleSetting::first();
    }

    /**
     * Update or create a schedule setting.
     *
     * @param array $data
     * @return ScheduleSetting
     */
    public function updateOrCreateScheduleSetting(array $data): ScheduleSetting
    {
        return DB::transaction(function () use ($data) {
            $data['updated_by'] = auth()->id() ?? 1;
            return ScheduleSetting::updateOrCreate(['id' => 1], $data);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | SMS Settings Methods
    |--------------------------------------------------------------------------
    |
    | These methods handle all SMS setting-related operations including
    | CRUD operations for SMS settings and SMS setting filtering.
    |
    */

    /**
     * Get SMS setting.
     *
     * @return SmsSetting
     */
    public function getSmsSetting(): SmsSetting
    {
        return SmsSetting::first();
    }

    /**
     * Update or create an SMS setting.
     *
     * @param array $data
     * @return SmsSetting
     */
    public function updateOrCreateSmsSetting(array $data): SmsSetting
    {
        return DB::transaction(function () use ($data) {
            $data['updated_by'] = auth()->id() ?? 1;
            $result = SmsSetting::updateOrCreate(['id' => 1], $data);
            
            // Update environment variables for SMS
            $this->updateEnvVariable('SMS_GATEWAY', '"' . ($data['status'] ?? 'none') . '"');
            
            // Vonage/Nexmo settings
            $this->updateEnvVariable('VONAGE_KEY', '"' . ($data['vonage_key'] ?? '') . '"');
            $this->updateEnvVariable('VONAGE_SECRET', '"' . ($data['vonage_secret'] ?? '') . '"');
            $this->updateEnvVariable('VONAGE_NUMBER', '"' . ($data['vonage_number'] ?? '') . '"');
            
            // Twilio settings
            $this->updateEnvVariable('TWILIO_SID', '"' . ($data['twilio_sid'] ?? '') . '"');
            $this->updateEnvVariable('TWILIO_AUTH_TOKEN', '"' . ($data['twilio_auth_token'] ?? '') . '"');
            $this->updateEnvVariable('TWILIO_NUMBER', '"' . ($data['twilio_number'] ?? '') . '"');
            
            // Africa's Talking settings
            $this->updateEnvVariable('AFRICASTALKING_USERNAME', '"' . ($data['africas_talking_username'] ?? '') . '"');
            $this->updateEnvVariable('AFRICASTALKING_API_KEY', '"' . ($data['africas_talking_key'] ?? '') . '"');
            
            // TextLocal settings
            $this->updateEnvVariable('TEXT_LOCAL_KEY', '"' . ($data['textlocal_key'] ?? '') . '"');
            $this->updateEnvVariable('TEXT_LOCAL_SENDER', '"' . ($data['textlocal_sender'] ?? '') . '"');
            
            // Clickatell settings
            $this->updateEnvVariable('CLICKATELL_API_KEY', '"' . ($data['clickatell_key'] ?? '') . '"');
            
            // SMS Country settings
            $this->updateEnvVariable('SMSCOUNTRY_USER', '"' . ($data['sms_country_username'] ?? '') . '"');
            $this->updateEnvVariable('SMSCOUNTRY_PASSWORD', '"' . ($data['sms_country_password'] ?? '') . '"');
            $this->updateEnvVariable('SMSCOUNTRY_SENDER_ID', '"' . ($data['sms_country_sender_id'] ?? '') . '"');
            
            return $result;
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Social Settings Methods
    |--------------------------------------------------------------------------
    |
    | These methods handle all social setting-related operations including
    | CRUD operations for social settings and social setting filtering.
    |
    */

    /**
     * Get social setting.
     *
     * @return SocialSetting
     */
    public function getSocialSetting(): SocialSetting
    {
        return SocialSetting::first();
    }

    /**
     * Update or create a social setting.
     *
     * @param array $data
     * @return SocialSetting
     */
    public function updateOrCreateSocialSetting(array $data): SocialSetting
    {
        return DB::transaction(function () use ($data) {
            $data['updated_by'] = auth()->id() ?? 1;
            return SocialSetting::updateOrCreate(['id' => 1], $data);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | System Settings Methods
    |--------------------------------------------------------------------------
    |
    | These methods handle system settings operations including retrieval
    | and updates for the main system settings table.
    |
    */

    /**
     * Get system settings (main settings table).
     *
     * @return Setting
     */
    public function getSystemSettings(): Setting
    {
        return Setting::firstOrFail();
    }

    /**
     * Update or create system settings.
     *
     * @param array $data
     * @return Setting
     */
    public function updateOrCreateSystemSettings(array $data): Setting
    {
        return DB::transaction(function () use ($data) {
            $data['updated_by'] = auth()->id() ?? 1;
            return Setting::updateOrCreate(['id' => 1], $data);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Topbar Settings Methods
    |--------------------------------------------------------------------------
    |
    | These methods handle all topbar setting-related operations including
    | CRUD operations for topbar settings and topbar setting filtering.
    |
    */

    /**
     * Get topbar setting.
     *
     * @return TopbarSetting
     */
    public function getTopbarSetting(): TopbarSetting
    {
        return TopbarSetting::first();
    }

    /**
     * Update or create a topbar setting.
     *
     * @param array $data
     * @return TopbarSetting
     */
    public function updateOrCreateTopbarSetting(array $data): TopbarSetting
    {
        return DB::transaction(function () use ($data) {
            $data['updated_by'] = auth()->id() ?? 1;
            return TopbarSetting::updateOrCreate(['id' => 1], $data);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Statistics Methods
    |--------------------------------------------------------------------------
    |
    | These methods handle settings statistics and analytics including
    | counts and summaries of all settings types.
    |
    */

    /**
     * Get all settings statistics.
     *
     * @return array
     */
    public function getSettingsStatistics(): array
    {
        $applicationSettings = ApplicationSetting::count();
        $mailSettings = MailSetting::count();
        $smsSettings = SmsSetting::count();
        $socialSettings = SocialSetting::count();
        $idCardSettings = IdCardSetting::count();
        $marksheetSettings = MarksheetSetting::count();
        $printSettings = PrintSetting::count();
        $taxSettings = TaxSetting::count();
        $topbarSettings = TopbarSetting::count();
        $scheduleSettings = ScheduleSetting::count();

        return [
            'application_settings' => $applicationSettings,
            'mail_settings' => $mailSettings,
            'sms_settings' => $smsSettings,
            'social_settings' => $socialSettings,
            'id_card_settings' => $idCardSettings,
            'marksheet_settings' => $marksheetSettings,
            'print_settings' => $printSettings,
            'tax_settings' => $taxSettings,
            'topbar_settings' => $topbarSettings,
            'schedule_settings' => $scheduleSettings,
            'total_settings' => $applicationSettings + $mailSettings + $smsSettings + 
                              $socialSettings + $idCardSettings + $marksheetSettings + 
                              $printSettings + $taxSettings + $topbarSettings + $scheduleSettings,
        ];
    }

}
