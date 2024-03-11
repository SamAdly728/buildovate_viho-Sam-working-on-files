<?php
namespace App\Config;

class CompanyBasicInformation
{
    /**
     * @return array[]
     */
    public function timezone(): array
    {
        return [
            array( 'name' => "(GMT -12:00) Eniwetok, Kwajalein", 'value'  => "-12:00" ),
            array( 'name' => "(GMT -11:00) Midway Island, Samoa", 'value'  => "-11:00" ),
            array( 'name' => "(GMT -10:00) Hawaii", 'value'  => "-10:00" ),
            array( 'name' => "(GMT -9:30) Taiohae", 'value'  => "-09:50" ),
            array( 'name' => "(GMT -9:00) Alaska", 'value'  => "-09:00" ),
            array( 'name' => "(GMT -8:00) Pacific Time (US &amp; Canada)",'value'  => "-08:00" ),
            array( 'name' => "(GMT -7:00) Mountain Time (US &amp; Canada)",'value'  => "-07:00" ),
            array( 'name' => "(GMT -6:00) Central Time (US &amp; Canada), Mexico City", 'value'  => "-06:00" ),
            array( 'name' => "(GMT -5:00) Eastern Time (US &amp; Canada), Bogota, Lima", 'value'  => "-05:00" ),
            array( 'name' => "(GMT -4:30) Caracas", 'value'  => "-04:50" ),
            array( 'name' => "(GMT -4:00) Atlantic Time (Canada), Caracas, La Paz", 'value'  => "-04:00" ),
            array( 'name' => "(GMT -3:30) Newfoundland", 'value'  => "-03:50" ),
            array( 'name' => "(GMT -3:00) Brazil, Buenos Aires, Georgetown",'value'  => "-03:00" ),
            array( 'name' => "(GMT -2:00) Mid-Atlantic",'value'  => "-02:00" ),
            array( 'name' => "(GMT -1:00) Azores, Cape Verde Islands", 'value'  => "-01:00" ),
            array( 'name' => "(GMT) Western Europe Time, London, Lisbon, Casablanca", 'value'  => "+00:00" ),
            array( 'name' => "(GMT +1:00) Brussels, Copenhagen, Madrid, Paris",'value'  => "+01:00" ),
            array( 'name' => "(GMT +2:00) Kaliningrad, South Africa", 'value'  => "+02:00" ),
            array( 'name' => "(GMT +3:00) Baghdad, Riyadh, Moscow, St. Petersburg", 'value'  => "+03:00" ),
            array( 'name' => "(GMT +3:30) Tehran", 'value'  =>"+03:50" ),
            array( 'name' => "(GMT +4:00) Abu Dhabi, Muscat, Baku, Tbilisi", 'value'  =>"+04:00" ),
            array( 'name' => "(GMT +4:30) Kabul", 'value'  => "+04:50" ),
            array( 'name' => "(GMT +5:00) Ekaterinburg, Islamabad, Karachi, Tashkent",'value'  => "+05:00" ),
            array( 'name' => "(GMT +5:30) Bombay, Calcutta, Madras, New Delhi",'value'  => "+05:50" ),
            array( 'name' => "(GMT +5:45) Kathmandu, Pokhara", 'value'  =>"+05:75" ),
            array( 'name' => "(GMT +6:00) Almaty, Dhaka, Colombo", 'value'  => "+06:00" ),
            array( 'name' => "(GMT +6:30) Yangon, Mandalay", 'value'  => "+06:50" ),
            array( 'name' => "(GMT +7:00) Bangkok, Hanoi, Jakarta", 'value'  => "+07:00" ),
            array( 'name' => "(GMT +8:00) Beijing, Perth, Singapore, Hong Kong", 'value'  =>"+08:00" ),
            array( 'name' => "(GMT +8:45) Eucla", 'value'  => "+08:75" ),
            array( 'name' => "(GMT +9:00) Tokyo, Seoul, Osaka, Sapporo, Yakutsk",'value'  =>"+09:00" ),
            array( 'name' => "(GMT +9:30) Adelaide, Darwin", 'value'  => "+09:50" ),
            array( 'name' => "(GMT +10:00) Eastern Australia, Guam, Vladivostok", 'value'  =>"+10:00" ),
            array( 'name' => "(GMT +10:30) Lord Howe Island", 'value'  => "+10:50" ),
            array( 'name' => "(GMT +11:00) Magadan, Solomon Islands, New Caledonia", 'value'  => "+11:00" ),
            array( 'name' => "(GMT +11:30) Norfolk Island", 'value'  => "+11:50" ),
            array( 'name' => "(GMT +12:00) Auckland, Wellington, Fiji, Kamchatka", 'value'  => "+12:00" ),
            array( 'name' => "(GMT +12:45) Chatham Islands", 'value'  => "+12:75" ),
            array( 'name' => "(GMT +13:00) Apia, Nukualofa", 'value'  => "+13:00" ),
            array( 'name' => "(GMT +14:00) Line Islands, Tokelau", 'value'  =>"+14:00" )
        ];
    }

    /**
     * @return string[]
     */
    public function dateFormat(): array
    {
        return [
            array('name' => date('Y-m-d'), 'value' => 'Y-m-d'),
            array('name' => date('d/m/Y'), 'value' => 'd/m/Y'),
            array('name' => date('m/d/Y'), 'value' => 'm/d/Y'),
            array('name' => date('d-M-Y'), 'value' => 'd-M-Y'),
            array('name' => date('l, F j, Y'), 'value' => 'l, F j, Y'),
            array('name' => date('jS F Y'), 'value' => 'jS F Y'),
            array('name' => date('Y-m-d'), 'value' => 'Y-m-d')
        ];

    }

    /**
     * @return string[]
     */
    public function timeFormat(): array
    {
        return [
            array('name' => date('g:i a'), 'value' => 'g:i a'),          // 12-hour time with lowercase AM/PM (e.g., 2:15 pm)
            array('name' => date('g:i A'), 'value' => 'g:i A'),          // 12-hour time with uppercase AM/PM (e.g., 2:15 PM)
            array('name' =>date('G:i'), 'value' => 'G:i'),            // 24-hour time without leading zero (e.g., 2:15 or 14:15)
            array('name' =>date('H:i'), 'value' => 'H:i'),            // 24-hour time with leading zero (e.g., 02:15 or 14:15)
            array('name' =>date('h:i a'), 'value' => 'h:i a'),          // 12-hour time with leading zero and lowercase AM/PM (e.g., 02:15 pm)
            array('name' =>date('h:i A'), 'value' => 'h:i A'),          // 12-hour time with leading zero and uppercase AM/PM (e.g., 02:15 PM)
            array('name' =>date('g:i:s a'), 'value' => 'g:i:s a'),        // 12-hour time with seconds and lowercase AM/PM (e.g., 2:15:30 pm)
            array('name' =>date('G:i:s'), 'value' => 'G:i:s'),          // 24-hour time with seconds (e.g., 14:15:30)
            array('name' =>date('h:i:s A'), 'value' => 'h:i:s A')         // 12-hour time with leading zero, seconds, and uppercase AM/PM (e.g., 02:15:30 PM)
        ];
    }

    /**
     * @return string[]
     */
    public function daysOfWeek(): array
    {
        return [
            'Sunday',
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday'
        ];
    }
}