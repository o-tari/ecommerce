<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\OrderStatus;
use App\Models\Tag;
use App\Models\Country;

class DefaultDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Attributes and Attribute Values
        $colorAttribute = Attribute::create(['attribute_name' => 'Color']);
        $sizeAttribute = Attribute::create(['attribute_name' => 'Size']);

        $colorAttribute->attributeValues()->createMany([
            ['attribute_value' => 'black', 'color' => '#000'],
            ['attribute_value' => 'white', 'color' => '#FFF'],
            ['attribute_value' => 'red', 'color' => '#FF0000'],
        ]);

        $sizeAttribute->attributeValues()->createMany([
            ['attribute_value' => 'S'],
            ['attribute_value' => 'M'],
            ['attribute_value' => 'L'],
            ['attribute_value' => 'XL'],
            ['attribute_value' => '2XL'],
            ['attribute_value' => '3XL'],
            ['attribute_value' => '4XL'],
            ['attribute_value' => '5XL'],
        ]);

        // Order Statuses
        $orderStatuses = [
            ['status_name' => 'Delivered', 'color' => '#5ae510', 'privacy' => 'public'],
            ['status_name' => 'Unreached', 'color' => '#ff03d3', 'privacy' => 'public'],
            ['status_name' => 'Paid', 'color' => '#4caf50', 'privacy' => 'public'],
            ['status_name' => 'Confirmed', 'color' => '#00d4cb', 'privacy' => 'public'],
            ['status_name' => 'Processing', 'color' => '#ab5ae9', 'privacy' => 'public'],
            ['status_name' => 'Pending', 'color' => '#ffe224', 'privacy' => 'public'],
            ['status_name' => 'On Hold', 'color' => '#d6d6d6', 'privacy' => 'public'],
            ['status_name' => 'Shipped', 'color' => '#71f9f7', 'privacy' => 'public'],
            ['status_name' => 'Cancelled', 'color' => '#FD9F3D', 'privacy' => 'public'],
            ['status_name' => 'Refused', 'color' => '#FF532F', 'privacy' => 'private'],
            ['status_name' => 'Awaiting Return', 'color' => '#000', 'privacy' => 'private'],
            ['status_name' => 'Returned', 'color' => '#000', 'privacy' => 'private'],
        ];
        foreach ($orderStatuses as $status) {
            OrderStatus::create($status);
        }

        // Roles
        Role::create(['name' => 'Store Administrator']);
        Role::create(['name' => 'Sales Manager']);
        Role::create(['name' => 'Sales Staff']);
        Role::create(['name' => 'Guest']);
        Role::create(['name' => 'Investor']);

        // Tags
        $tags = [
            ['tag_name' => 'Tools'],
            ['tag_name' => 'Beauty Health'],
            ['tag_name' => 'Shirts'],
            ['tag_name' => 'Accessories'],
        ];
        foreach ($tags as $tag) {
            Tag::create($tag);
        }

        // Countries - Part 1
        $countries_part1 = [
            ['iso' => 'AF', 'name' => 'Afghanistan', 'upper_name' => 'AFGHANISTAN', 'iso3' => 'AFG', 'num_code' => 4, 'phone_code' => 93],
            ['iso' => 'AL', 'name' => 'Albania', 'upper_name' => 'ALBANIA', 'iso3' => 'ALB', 'num_code' => 8, 'phone_code' => 355],
            ['iso' => 'DZ', 'name' => 'Algeria', 'upper_name' => 'ALGERIA', 'iso3' => 'DZA', 'num_code' => 12, 'phone_code' => 213],
            ['iso' => 'AS', 'name' => 'American Samoa', 'upper_name' => 'AMERICAN SAMOA', 'iso3' => 'ASM', 'num_code' => 16, 'phone_code' => 1684],
            ['iso' => 'AD', 'name' => 'Andorra', 'upper_name' => 'ANDORRA', 'iso3' => 'AND', 'num_code' => 20, 'phone_code' => 376],
            ['iso' => 'AO', 'name' => 'Angola', 'upper_name' => 'ANGOLA', 'iso3' => 'AGO', 'num_code' => 24, 'phone_code' => 244],
            ['iso' => 'AI', 'name' => 'Anguilla', 'upper_name' => 'ANGUILLA', 'iso3' => 'AIA', 'num_code' => 660, 'phone_code' => 1264],
            ['iso' => 'AQ', 'name' => 'Antarctica', 'upper_name' => 'ANTARCTICA', 'iso3' => 'ATA', 'num_code' => 10, 'phone_code' => 0],
            ['iso' => 'AG', 'name' => 'Antigua and Barbuda', 'upper_name' => 'ANTIGUA AND BARBUDA', 'iso3' => 'ATG', 'num_code' => 28, 'phone_code' => 1268],
            ['iso' => 'AR', 'name' => 'Argentina', 'upper_name' => 'ARGENTINA', 'iso3' => 'ARG', 'num_code' => 32, 'phone_code' => 54],
            ['iso' => 'AM', 'name' => 'Armenia', 'upper_name' => 'ARMENIA', 'iso3' => 'ARM', 'num_code' => 51, 'phone_code' => 374],
            ['iso' => 'AW', 'name' => 'Aruba', 'upper_name' => 'ARUBA', 'iso3' => 'ABW', 'num_code' => 533, 'phone_code' => 297],
            ['iso' => 'AU', 'name' => 'Australia', 'upper_name' => 'AUSTRALIA', 'iso3' => 'AUS', 'num_code' => 36, 'phone_code' => 61],
            ['iso' => 'AT', 'name' => 'Austria', 'upper_name' => 'AUSTRIA', 'iso3' => 'AUT', 'num_code' => 40, 'phone_code' => 43],
            ['iso' => 'AZ', 'name' => 'Azerbaijan', 'upper_name' => 'AZERBAIJAN', 'iso3' => 'AZE', 'num_code' => 31, 'phone_code' => 994],
            ['iso' => 'BS', 'name' => 'Bahamas', 'upper_name' => 'BAHAMAS', 'iso3' => 'BHS', 'num_code' => 44, 'phone_code' => 1242],
            ['iso' => 'BH', 'name' => 'Bahrain', 'upper_name' => 'BAHRAIN', 'iso3' => 'BHR', 'num_code' => 48, 'phone_code' => 973],
            ['iso' => 'BD', 'name' => 'Bangladesh', 'upper_name' => 'BANGLADESH', 'iso3' => 'BGD', 'num_code' => 50, 'phone_code' => 880],
            ['iso' => 'BB', 'name' => 'Barbados', 'upper_name' => 'BARBADOS', 'iso3' => 'BRB', 'num_code' => 52, 'phone_code' => 1246],
            ['iso' => 'BY', 'name' => 'Belarus', 'upper_name' => 'BELARUS', 'iso3' => 'BLR', 'num_code' => 112, 'phone_code' => 375],
        ];
        foreach ($countries_part1 as $country) {
            Country::create($country);
        }

        // Countries - Part 2
        $countries_part2 = [
            ['iso' => 'BE', 'name' => 'Belgium', 'upper_name' => 'BELGIUM', 'iso3' => 'BEL', 'num_code' => 56, 'phone_code' => 32],
            ['iso' => 'BZ', 'name' => 'Belize', 'upper_name' => 'BELIZE', 'iso3' => 'BLZ', 'num_code' => 84, 'phone_code' => 501],
            ['iso' => 'BJ', 'name' => 'Benin', 'upper_name' => 'BENIN', 'iso3' => 'BEN', 'num_code' => 204, 'phone_code' => 229],
            ['iso' => 'BM', 'name' => 'Bermuda', 'upper_name' => 'BERMUDA', 'iso3' => 'BMU', 'num_code' => 60, 'phone_code' => 1441],
            ['iso' => 'BT', 'name' => 'Bhutan', 'upper_name' => 'BHUTAN', 'iso3' => 'BTN', 'num_code' => 64, 'phone_code' => 975],
            ['iso' => 'BO', 'name' => 'Bolivia', 'upper_name' => 'BOLIVIA', 'iso3' => 'BOL', 'num_code' => 68, 'phone_code' => 591],
            ['iso' => 'BA', 'name' => 'Bosnia and Herzegovina', 'upper_name' => 'BOSNIA AND HERZEGOVINA', 'iso3' => 'BIH', 'num_code' => 70, 'phone_code' => 387],
            ['iso' => 'BW', 'name' => 'Botswana', 'upper_name' => 'BOTSWANA', 'iso3' => 'BWA', 'num_code' => 72, 'phone_code' => 267],
            ['iso' => 'BR', 'name' => 'Brazil', 'upper_name' => 'BRAZIL', 'iso3' => 'BRA', 'num_code' => 76, 'phone_code' => 55],
            ['iso' => 'IO', 'name' => 'British Indian Ocean Territory', 'upper_name' => 'BRITISH INDIAN OCEAN TERRITORY', 'iso3' => 'IOT', 'num_code' => 86, 'phone_code' => 246],
            ['iso' => 'BN', 'name' => 'Brunei Darussalam', 'upper_name' => 'BRUNEI DARUSSALAM', 'iso3' => 'BRN', 'num_code' => 96, 'phone_code' => 673],
            ['iso' => 'BG', 'name' => 'Bulgaria', 'upper_name' => 'BULGARIA', 'iso3' => 'BGR', 'num_code' => 100, 'phone_code' => 359],
            ['iso' => 'BF', 'name' => 'Burkina Faso', 'upper_name' => 'BURKINA FASO', 'iso3' => 'BFA', 'num_code' => 854, 'phone_code' => 226],
            ['iso' => 'BI', 'name' => 'Burundi', 'upper_name' => 'BURUNDI', 'iso3' => 'BDI', 'num_code' => 108, 'phone_code' => 257],
            ['iso' => 'KH', 'name' => 'Cambodia', 'upper_name' => 'CAMBODIA', 'iso3' => 'KHM', 'num_code' => 116, 'phone_code' => 855],
            ['iso' => 'CM', 'name' => 'Cameroon', 'upper_name' => 'CAMEROON', 'iso3' => 'CMR', 'num_code' => 120, 'phone_code' => 237],
            ['iso' => 'CA', 'name' => 'Canada', 'upper_name' => 'CANADA', 'iso3' => 'CAN', 'num_code' => 124, 'phone_code' => 1],
            ['iso' => 'CV', 'name' => 'Cape Verde', 'upper_name' => 'CAPE VERDE', 'iso3' => 'CPV', 'num_code' => 132, 'phone_code' => 238],
            ['iso' => 'KY', 'name' => 'Cayman Islands', 'upper_name' => 'CAYMAN ISLANDS', 'iso3' => 'CYM', 'num_code' => 136, 'phone_code' => 1345],
            ['iso' => 'CF', 'name' => 'Central African Republic', 'upper_name' => 'CENTRAL AFRICAN REPUBLIC', 'iso3' => 'CAF', 'num_code' => 140, 'phone_code' => 236],
            ['iso' => 'TD', 'name' => 'Chad', 'upper_name' => 'CHAD', 'iso3' => 'TCD', 'num_code' => 148, 'phone_code' => 235],
            ['iso' => 'CL', 'name' => 'Chile', 'upper_name' => 'CHILE', 'iso3' => 'CHL', 'num_code' => 152, 'phone_code' => 56],
            ['iso' => 'CN', 'name' => 'China', 'upper_name' => 'CHINA', 'iso3' => 'CHN', 'num_code' => 156, 'phone_code' => 86],
            ['iso' => 'CX', 'name' => 'Christmas Island', 'upper_name' => 'CHRISTMAS ISLAND', 'iso3' => 'CXR', 'num_code' => 162, 'phone_code' => 61],
            ['iso' => 'CC', 'name' => 'Cocos (Keeling) Islands', 'upper_name' => 'COCOS (KEELING) ISLANDS', 'iso3' => null, 'num_code' => null, 'phone_code' => 672],
            ['iso' => 'CO', 'name' => 'Colombia', 'upper_name' => 'COLOMBIA', 'iso3' => 'COL', 'num_code' => 170, 'phone_code' => 57],
            ['iso' => 'KM', 'name' => 'Comoros', 'upper_name' => 'COMOROS', 'iso3' => 'COM', 'num_code' => 174, 'phone_code' => 269],
            ['iso' => 'CG', 'name' => 'Congo', 'upper_name' => 'CONGO', 'iso3' => 'COG', 'num_code' => 178, 'phone_code' => 242],
            ['iso' => 'CD', 'name' => 'Congo, the Democratic Republic of the', 'upper_name' => 'CONGO, THE DEMOCRATIC REPUBLIC OF THE', 'iso3' => 'COD', 'num_code' => 180, 'phone_code' => 242],
            ['iso' => 'CK', 'name' => 'Cook Islands', 'upper_name' => 'COOK ISLANDS', 'iso3' => 'COK', 'num_code' => 184, 'phone_code' => 682],
            ['iso' => 'CR', 'name' => 'Costa Rica', 'upper_name' => 'COSTA RICA', 'iso3' => 'CRI', 'num_code' => 188, 'phone_code' => 506],
            ['iso' => 'CI', 'name' => 'Cote D\'Ivoire', 'upper_name' => 'COTE D\'IVOIRE', 'iso3' => 'CIV', 'num_code' => 384, 'phone_code' => 225],
            ['iso' => 'HR', 'name' => 'Croatia', 'upper_name' => 'CROATIA', 'iso3' => 'HRV', 'num_code' => 191, 'phone_code' => 385],
            ['iso' => 'CU', 'name' => 'Cuba', 'upper_name' => 'CUBA', 'iso3' => 'CUB', 'num_code' => 192, 'phone_code' => 53],
            ['iso' => 'CY', 'name' => 'Cyprus', 'upper_name' => 'CYPRUS', 'iso3' => 'CYP', 'num_code' => 196, 'phone_code' => 357],
            ['iso' => 'CZ', 'name' => 'Czechia', 'upper_name' => 'CZECHIA', 'iso3' => 'CZE', 'num_code' => 203, 'phone_code' => 420],
            ['iso' => 'DK', 'name' => 'Denmark', 'upper_name' => 'DENMARK', 'iso3' => 'DNK', 'num_code' => 208, 'phone_code' => 45],
            ['iso' => 'DJ', 'name' => 'Djibouti', 'upper_name' => 'DJIBOUTI', 'iso3' => 'DJI', 'num_code' => 262, 'phone_code' => 253],
            ['iso' => 'DM', 'name' => 'Dominica', 'upper_name' => 'DOMINICA', 'iso3' => 'DMA', 'num_code' => 212, 'phone_code' => 1767],
            ['iso' => 'DO', 'name' => 'Dominican Republic', 'upper_name' => 'DOMINICAN REPUBLIC', 'iso3' => 'DOM', 'num_code' => 214, 'phone_code' => 1],
            ['iso' => 'EC', 'name' => 'Ecuador', 'upper_name' => 'ECUADOR', 'iso3' => 'ECU', 'num_code' => 218, 'phone_code' => 593],
            ['iso' => 'EG', 'name' => 'Egypt', 'upper_name' => 'EGYPT', 'iso3' => 'EGY', 'num_code' => 818, 'phone_code' => 20],
            ['iso' => 'SV', 'name' => 'El Salvador', 'upper_name' => 'EL SALVADOR', 'iso3' => 'SLV', 'num_code' => 222, 'phone_code' => 503],
            ['iso' => 'GQ', 'name' => 'Equatorial Guinea', 'upper_name' => 'EQUATORIAL GUINEA', 'iso3' => 'GNQ', 'num_code' => 226, 'phone_code' => 240],
            ['iso' => 'ER', 'name' => 'Eritrea', 'upper_name' => 'ERITREA', 'iso3' => 'ERI', 'num_code' => 232, 'phone_code' => 291],
            ['iso' => 'EE', 'name' => 'Estonia', 'upper_name' => 'ESTONIA', 'iso3' => 'EST', 'num_code' => 233, 'phone_code' => 372],
            ['iso' => 'ET', 'name' => 'Ethiopia', 'upper_name' => 'ETHIOPIA', 'iso3' => 'ETH', 'num_code' => 231, 'phone_code' => 251],
            ['iso' => 'FK', 'name' => 'Falkland Islands (Malvinas)', 'upper_name' => 'FALKLAND ISLANDS (MALVINAS)', 'iso3' => 'FLK', 'num_code' => 238, 'phone_code' => 500],
            ['iso' => 'FO', 'name' => 'Faroe Islands', 'upper_name' => 'FAROE ISLANDS', 'iso3' => 'FRO', 'num_code' => 234, 'phone_code' => 298],
            ['iso' => 'FJ', 'name' => 'Fiji', 'upper_name' => 'FIJI', 'iso3' => 'FJI', 'num_code' => 242, 'phone_code' => 679],
            ['iso' => 'FI', 'name' => 'Finland', 'upper_name' => 'FINLAND', 'iso3' => 'FIN', 'num_code' => 246, 'phone_code' => 358],
            ['iso' => 'FR', 'name' => 'France', 'upper_name' => 'FRANCE', 'iso3' => 'FRA', 'num_code' => 250, 'phone_code' => 33],
            ['iso' => 'GF', 'name' => 'French Guiana', 'upper_name' => 'FRENCH GUANA', 'iso3' => 'GUF', 'num_code' => 254, 'phone_code' => 594],
            ['iso' => 'PF', 'name' => 'French Polynesia', 'upper_name' => 'FRENCH POLYNESIA', 'iso3' => 'PYF', 'num_code' => 258, 'phone_code' => 689],
            ['iso' => 'TF', 'name' => 'French Southern Territories', 'upper_name' => 'FRENCH SOUTHERN TERRITORIES', 'iso3' => 'ATF', 'num_code' => 260, 'phone_code' => 0],
            ['iso' => 'GA', 'name' => 'Gabon', 'upper_name' => 'GABON', 'iso3' => 'GAB', 'num_code' => 266, 'phone_code' => 241],
            ['iso' => 'GM', 'name' => 'Gambia', 'upper_name' => 'GAMBIA', 'iso3' => 'GMB', 'num_code' => 270, 'phone_code' => 220],
            ['iso' => 'GE', 'name' => 'Georgia', 'upper_name' => 'GEORGIA', 'iso3' => 'GEO', 'num_code' => 268, 'phone_code' => 995],
            ['iso' => 'DE', 'name' => 'Germany', 'upper_name' => 'GERMANY', 'iso3' => 'DEU', 'num_code' => 276, 'phone_code' => 49],
            ['iso' => 'GH', 'name' => 'Ghana', 'upper_name' => 'GHANA', 'iso3' => 'GHA', 'num_code' => 288, 'phone_code' => 233],
            ['iso' => 'GI', 'name' => 'Gibraltar', 'upper_name' => 'GIBRALTAR', 'iso3' => 'GIB', 'num_code' => 292, 'phone_code' => 350],
            ['iso' => 'GR', 'name' => 'Greece', 'upper_name' => 'GREECE', 'iso3' => 'GRC', 'num_code' => 300, 'phone_code' => 30],
            ['iso' => 'GL', 'name' => 'Greenland', 'upper_name' => 'GREENLAND', 'iso3' => 'GRL', 'num_code' => 304, 'phone_code' => 299],
            ['iso' => 'GD', 'name' => 'Grenada', 'upper_name' => 'GRENADA', 'iso3' => 'GRD', 'num_code' => 308, 'phone_code' => 1473],
            ['iso' => 'GP', 'name' => 'Guadeloupe', 'upper_name' => 'GUADELOUPE', 'iso3' => 'GLP', 'num_code' => 312, 'phone_code' => 590],
            ['iso' => 'GU', 'name' => 'Guam', 'upper_name' => 'GUAM', 'iso3' => 'GUM', 'num_code' => 316, 'phone_code' => 1671],
            ['iso' => 'GT', 'name' => 'Guatemala', 'upper_name' => 'GUATEMALA', 'iso3' => 'GTM', 'num_code' => 320, 'phone_code' => 502],
            ['iso' => 'GN', 'name' => 'Guinea', 'upper_name' => 'GUINEA', 'iso3' => 'GIN', 'num_code' => 324, 'phone_code' => 224],
            ['iso' => 'GW', 'name' => 'Guinea-Bissau', 'upper_name' => 'GUINEA-BISSAU', 'iso3' => 'GNB', 'num_code' => 624, 'phone_code' => 245],
            ['iso' => 'GY', 'name' => 'Guyana', 'upper_name' => 'GUYANA', 'iso3' => 'GUY', 'num_code' => 328, 'phone_code' => 592],
            ['iso' => 'HT', 'name' => 'Haiti', 'upper_name' => 'HAITI', 'iso3' => 'HTI', 'num_code' => 332, 'phone_code' => 509],
            ['iso' => 'HM', 'name' => 'Heard Island and Mcdonald Islands', 'upper_name' => 'HEARD ISLAND AND MCDONALD ISLANDS', 'iso3' => 'HMD', 'num_code' => 334, 'phone_code' => 0],
            ['iso' => 'VA', 'name' => 'Holy See (Vatican City State)', 'upper_name' => 'HOLY SEE (VATICAL CITY STATE)', 'iso3' => 'VAT', 'num_code' => 336, 'phone_code' => 39],
            ['iso' => 'HN', 'name' => 'Honduras', 'upper_name' => 'HONDURAS', 'iso3' => 'HND', 'num_code' => 340, 'phone_code' => 504],
            ['iso' => 'HK', 'name' => 'Hong Kong', 'upper_name' => 'HONG KONG', 'iso3' => 'HKG', 'num_code' => 344, 'phone_code' => 852],
            ['iso' => 'HU', 'name' => 'Hungary', 'upper_name' => 'HUNGARY', 'iso3' => 'HUN', 'num_code' => 348, 'phone_code' => 36],
            ['iso' => 'IS', 'name' => 'Iceland', 'upper_name' => 'ICELAND', 'iso3' => 'ISL', 'num_code' => 352, 'phone_code' => 354],
            ['iso' => 'IN', 'name' => 'India', 'upper_name' => 'INDIA', 'iso3' => 'IND', 'num_code' => 356, 'phone_code' => 91],
            ['iso' => 'ID', 'name' => 'Indonesia', 'upper_name' => 'INDONESIA', 'iso3' => 'IDN', 'num_code' => 360, 'phone_code' => 62],
            ['iso' => 'IR', 'name' => 'Iran, Islamic Republic of', 'upper_name' => 'IRAN, ISLAMIC REPUBLIC OF', 'iso3' => 'IRN', 'num_code' => 364, 'phone_code' => 98],
            ['iso' => 'IQ', 'name' => 'Iraq', 'upper_name' => 'IRAQ', 'iso3' => 'IRQ', 'num_code' => 368, 'phone_code' => 964],
            ['iso' => 'IE', 'name' => 'Ireland', 'upper_name' => 'IRELAND', 'iso3' => 'IRL', 'num_code' => 372, 'phone_code' => 353],
            ['iso' => 'IL', 'name' => 'Israel', 'upper_name' => 'ISRAEL', 'iso3' => 'ISR', 'num_code' => 376, 'phone_code' => 972],
            ['iso' => 'IT', 'name' => 'Italy', 'upper_name' => 'ITALY', 'iso3' => 'ITA', 'num_code' => 380, 'phone_code' => 39],
            ['iso' => 'JM', 'name' => 'Jamaica', 'upper_name' => 'JAMAICA', 'iso3' => 'JAM', 'num_code' => 388, 'phone_code' => 1876],
            ['iso' => 'JP', 'name' => 'Japan', 'upper_name' => 'JAPAN', 'iso3' => 'JPN', 'num_code' => 392, 'phone_code' => 81],
            ['iso' => 'JO', 'name' => 'Jordan', 'upper_name' => 'JORDAN', 'iso3' => 'JOR', 'num_code' => 400, 'phone_code' => 962],
            ['iso' => 'KZ', 'name' => 'Kazakhstan', 'upper_name' => 'KAZAKHSTAN', 'iso3' => 'KAZ', 'num_code' => 398, 'phone_code' => 7],
            ['iso' => 'KE', 'name' => 'Kenya', 'upper_name' => 'KENYA', 'iso3' => 'KEN', 'num_code' => 404, 'phone_code' => 254],
            ['iso' => 'KI', 'name' => 'Kiribati', 'upper_name' => 'KIRIBATI', 'iso3' => 'KIR', 'num_code' => 296, 'phone_code' => 686],
            ['iso' => 'KP', 'name' => 'Korea, Democratic People\'s Republic of', 'upper_name' => 'KOREA, DEMOCRATIC PEOPLE\'S REPUBLIC OF', 'iso3' => 'PRK', 'num_code' => 408, 'phone_code' => 850],
            ['iso' => 'KR', 'name' => 'Korea, Republic of', 'upper_name' => 'KOREA, REPUBLIC OF', 'iso3' => 'KOR', 'num_code' => 410, 'phone_code' => 82],
            ['iso' => 'KW', 'name' => 'Kuwait', 'upper_name' => 'KUWAIT', 'iso3' => 'KWT', 'num_code' => 414, 'phone_code' => 965],
            ['iso' => 'KG', 'name' => 'Kyrgyzstan', 'upper_name' => 'KYRGYZSTAN', 'iso3' => 'KGZ', 'num_code' => 417, 'phone_code' => 996],
            ['iso' => 'LA', 'name' => 'Lao People\'s Democratic Republic', 'upper_name' => 'LAO PEOPLE\'S DEMOCRATIC REPUBLIC', 'iso3' => 'LAO', 'num_code' => 418, 'phone_code' => 856],
            ['iso' => 'LV', 'name' => 'Latvia', 'upper_name' => 'LATVIA', 'iso3' => 'LVA', 'num_code' => 428, 'phone_code' => 371],
            ['iso' => 'LB', 'name' => 'Lebanon', 'upper_name' => 'LEBANON', 'iso3' => 'LBN', 'num_code' => 422, 'phone_code' => 961],
            ['iso' => 'LS', 'name' => 'Lesotho', 'upper_name' => 'LESOTHO', 'iso3' => 'LSO', 'num_code' => 426, 'phone_code' => 266],
            ['iso' => 'LR', 'name' => 'Liberia', 'upper_name' => 'LIBERIA', 'iso3' => 'LBR', 'num_code' => 430, 'phone_code' => 231],
            ['iso' => 'LY', 'name' => 'Libyan Arab Jamahiriya', 'upper_name' => 'LIBYAN ARAB JAMAHIRIYA', 'iso3' => 'LBY', 'num_code' => 434, 'phone_code' => 218],
            ['iso' => 'LI', 'name' => 'Liechtenstein', 'upper_name' => 'LIECHTENSTEIN', 'iso3' => 'LIE', 'num_code' => 438, 'phone_code' => 423],
            ['iso' => 'LT', 'name' => 'Lithuania', 'upper_name' => 'LITHUANIA', 'iso3' => 'LTU', 'num_code' => 440, 'phone_code' => 370],
            ['iso' => 'LU', 'name' => 'Luxembourg', 'upper_name' => 'LUXEMBOURG', 'iso3' => 'LUX', 'num_code' => 442, 'phone_code' => 352],
            ['iso' => 'MO', 'name' => 'Macao', 'upper_name' => 'MACAO', 'iso3' => 'MAC', 'num_code' => 446, 'phone_code' => 853],
            ['iso' => 'MK', 'name' => 'North Macedonia', 'upper_name' => 'NORTH MACEDONIA', 'iso3' => 'MKD', 'num_code' => 807, 'phone_code' => 389],
            ['iso' => 'MG', 'name' => 'Madagascar', 'upper_name' => 'MADAGASCAR', 'iso3' => 'MDG', 'num_code' => 450, 'phone_code' => 261],
            ['iso' => 'MW', 'name' => 'Malawi', 'upper_name' => 'MALAWI', 'iso3' => 'MWI', 'num_code' => 454, 'phone_code' => 265],
            ['iso' => 'MY', 'name' => 'Malaysia', 'upper_name' => 'MALAYSIA', 'iso3' => 'MYS', 'num_code' => 458, 'phone_code' => 60],
            ['iso' => 'MV', 'name' => 'Maldives', 'upper_name' => 'MALDIVES', 'iso3' => 'MDV', 'num_code' => 462, 'phone_code' => 960],
            ['iso' => 'ML', 'name' => 'Mali', 'upper_name' => 'MALI', 'iso3' => 'MLI', 'num_code' => 466, 'phone_code' => 223],
            ['iso' => 'MT', 'name' => 'Malta', 'upper_name' => 'MALTA', 'iso3' => 'MLT', 'num_code' => 470, 'phone_code' => 356],
            ['iso' => 'MH', 'name' => 'Marshall Islands', 'upper_name' => 'MARSHALL ISLANDS', 'iso3' => 'MHL', 'num_code' => 584, 'phone_code' => 692],
            ['iso' => 'MQ', 'name' => 'Martinique', 'upper_name' => 'MARTINIQUE', 'iso3' => 'MTQ', 'num_code' => 474, 'phone_code' => 596],
            ['iso' => 'MR', 'name' => 'Mauritania', 'upper_name' => 'MAURITANIA', 'iso3' => 'MRT', 'num_code' => 478, 'phone_code' => 222],
            ['iso' => 'MU', 'name' => 'Mauritius', 'upper_name' => 'MAURITIUS', 'iso3' => 'MUS', 'num_code' => 480, 'phone_code' => 230],
            ['iso' => 'YT', 'name' => 'Mayotte', 'upper_name' => 'MAYOTTE', 'iso3' => 'MYT', 'num_code' => 175, 'phone_code' => 269],
            ['iso' => 'MX', 'name' => 'Mexico', 'upper_name' => 'MEXICO', 'iso3' => 'MEX', 'num_code' => 484, 'phone_code' => 52],
            ['iso' => 'FM', 'name' => 'Micronesia, Federated States of', 'upper_name' => 'MICRONESIA, FEDERATED STATES OF', 'iso3' => 'FSM', 'num_code' => 583, 'phone_code' => 691],
            ['iso' => 'MD', 'name' => 'Moldova, Republic of', 'upper_name' => 'MOLDOVA, REPUBLIC OF', 'iso3' => 'MDA', 'num_code' => 498, 'phone_code' => 373],
            ['iso' => 'MC', 'name' => 'Monaco', 'upper_name' => 'MONACO', 'iso3' => 'MCO', 'num_code' => 492, 'phone_code' => 377],
            ['iso' => 'MN', 'name' => 'Mongolia', 'upper_name' => 'MONGOLIA', 'iso3' => 'MNG', 'num_code' => 496, 'phone_code' => 976],
            ['iso' => 'MS', 'name' => 'Montserrat', 'upper_name' => 'MONTSERRAT', 'iso3' => 'MSR', 'num_code' => 500, 'phone_code' => 1664],
            ['iso' => 'MA', 'name' => 'Morocco', 'upper_name' => 'MOROCCO', 'iso3' => 'MAR', 'num_code' => 504, 'phone_code' => 212],
            ['iso' => 'MZ', 'name' => 'Mozambique', 'upper_name' => 'MOZAMBIQUE', 'iso3' => 'MOZ', 'num_code' => 508, 'phone_code' => 258],
            ['iso' => 'MM', 'name' => 'Myanmar', 'upper_name' => 'MYANMAR', 'iso3' => 'MMR', 'num_code' => 104, 'phone_code' => 95],
            ['iso' => 'NA', 'name' => 'Namibia', 'upper_name' => 'NAMIBIA', 'iso3' => 'NAM', 'num_code' => 516, 'phone_code' => 264],
            ['iso' => 'NR', 'name' => 'Nauru', 'upper_name' => 'NAURU', 'iso3' => 'NRU', 'num_code' => 520, 'phone_code' => 674],
            ['iso' => 'NP', 'name' => 'Nepal', 'upper_name' => 'NEPAL', 'iso3' => 'NPL', 'num_code' => 524, 'phone_code' => 977],
            ['iso' => 'NL', 'name' => 'Netherlands', 'upper_name' => 'NETHERLANDS', 'iso3' => 'NLD', 'num_code' => 528, 'phone_code' => 31],
            ['iso' => 'AN', 'name' => 'Netherlands Antilles', 'upper_name' => 'NETHERLANDS ANTILLES', 'iso3' => 'ANT', 'num_code' => 530, 'phone_code' => 599],
            ['iso' => 'NC', 'name' => 'New Caledonia', 'upper_name' => 'NEW CALEDONIA', 'iso3' => 'NCL', 'num_code' => 540, 'phone_code' => 687],
            ['iso' => 'NZ', 'name' => 'New Zealand', 'upper_name' => 'NEW ZEALAND', 'iso3' => 'NZL', 'num_code' => 554, 'phone_code' => 64],
            ['iso' => 'NI', 'name' => 'Nicaragua', 'upper_name' => 'NICARAGUA', 'iso3' => 'NIC', 'num_code' => 558, 'phone_code' => 505],
            ['iso' => 'NE', 'name' => 'Niger', 'upper_name' => 'NIGER', 'iso3' => 'NER', 'num_code' => 562, 'phone_code' => 227],
            ['iso' => 'NG', 'name' => 'Nigeria', 'upper_name' => 'NIGERIA', 'iso3' => 'NGA', 'num_code' => 566, 'phone_code' => 234],
            ['iso' => 'NU', 'name' => 'Niue', 'upper_name' => 'NIUE', 'iso3' => 'NIU', 'num_code' => 570, 'phone_code' => 683],
            ['iso' => 'NF', 'name' => 'Norfolk Island', 'upper_name' => 'NORFOLK ISLAND', 'iso3' => 'NFK', 'num_code' => 574, 'phone_code' => 672],
            ['iso' => 'MP', 'name' => 'Northern Mariana Islands', 'upper_name' => 'NORTHERN MARIANA ISLANDS', 'iso3' => 'MNP', 'num_code' => 580, 'phone_code' => 1670],
            ['iso' => 'NO', 'name' => 'Norway', 'upper_name' => 'NORWAY', 'iso3' => 'NOR', 'num_code' => 578, 'phone_code' => 47],
            ['iso' => 'OM', 'name' => 'Oman', 'upper_name' => 'OMAN', 'iso3' => 'OMN', 'num_code' => 512, 'phone_code' => 968],
            ['iso' => 'PK', 'name' => 'Pakistan', 'upper_name' => 'PAKISTAN', 'iso3' => 'PAK', 'num_code' => 586, 'phone_code' => 92],
            ['iso' => 'PW', 'name' => 'Palau', 'upper_name' => 'PALAU', 'iso3' => 'PLW', 'num_code' => 585, 'phone_code' => 680],
            ['iso' => 'PS', 'name' => 'Palestinian Territory, Occupied', 'upper_name' => 'PALESTINIAN TERRITORY, OCCUPIED', 'iso3' => null, 'num_code' => null, 'phone_code' => 970],
            ['iso' => 'PA', 'name' => 'Panama', 'upper_name' => 'PANAMA', 'iso3' => 'PAN', 'num_code' => 591, 'phone_code' => 507],
            ['iso' => 'PG', 'name' => 'Papua New Guinea', 'upper_name' => 'PAPUA NEW GUINEA', 'iso3' => 'PNG', 'num_code' => 598, 'phone_code' => 675],
            ['iso' => 'PY', 'name' => 'Paraguay', 'upper_name' => 'PARAGUAY', 'iso3' => 'PRY', 'num_code' => 600, 'phone_code' => 595],
            ['iso' => 'PE', 'name' => 'Peru', 'upper_name' => 'PERU', 'iso3' => 'PER', 'num_code' => 604, 'phone_code' => 51],
            ['iso' => 'PH', 'name' => 'Philippines', 'upper_name' => 'PHILIPPINES', 'iso3' => 'PHL', 'num_code' => 608, 'phone_code' => 63],
            ['iso' => 'PN', 'name' => 'Pitcairn', 'upper_name' => 'PITCAIRN', 'iso3' => 'PCN', 'num_code' => 612, 'phone_code' => 0],
            ['iso' => 'PL', 'name' => 'Poland', 'upper_name' => 'POLAND', 'iso3' => 'POL', 'num_code' => 616, 'phone_code' => 48],
            ['iso' => 'PT', 'name' => 'Portugal', 'upper_name' => 'PORTUGAL', 'iso3' => 'PRT', 'num_code' => 620, 'phone_code' => 351],
            ['iso' => 'PR', 'name' => 'Puerto Rico', 'upper_name' => 'PUERTO RICO', 'iso3' => 'PRI', 'num_code' => 630, 'phone_code' => 1787],
            ['iso' => 'QA', 'name' => 'Qatar', 'upper_name' => 'QATAR', 'iso3' => 'QAT', 'num_code' => 634, 'phone_code' => 974],
            ['iso' => 'RE', 'name' => 'Reunion', 'upper_name' => 'REUNION', 'iso3' => 'REU', 'num_code' => 638, 'phone_code' => 262],
            ['iso' => 'RO', 'name' => 'Romania', 'upper_name' => 'ROMANIA', 'iso3' => 'ROU', 'num_code' => 642, 'phone_code' => 40],
            ['iso' => 'RU', 'name' => 'Russian Federation', 'upper_name' => 'RUSSIAN FEDERATION', 'iso3' => 'RUS', 'num_code' => 643, 'phone_code' => 7],
            ['iso' => 'RW', 'name' => 'Rwanda', 'upper_name' => 'RWANDA', 'iso3' => 'RWA', 'num_code' => 646, 'phone_code' => 250],
            ['iso' => 'SH', 'name' => 'Saint Helena', 'upper_name' => 'SAINT HELENA', 'iso3' => 'SHN', 'num_code' => 654, 'phone_code' => 290],
            ['iso' => 'KN', 'name' => 'Saint Kitts and Nevis', 'upper_name' => 'SAINT KITTS AND NEVIS', 'iso3' => 'KNA', 'num_code' => 659, 'phone_code' => 1869],
            ['iso' => 'LC', 'name' => 'Saint Lucia', 'upper_name' => 'SAINT LUCIA', 'iso3' => 'LCA', 'num_code' => 662, 'phone_code' => 1758],
            ['iso' => 'PM', 'name' => 'Saint Pierre and Miquelon', 'upper_name' => 'SAINT PIERRE AND MIQUELON', 'iso3' => 'SPM', 'num_code' => 666, 'phone_code' => 508],
            ['iso' => 'VC', 'name' => 'Saint Vincent and the Grenadines', 'upper_name' => 'SAINT VINCENT AND THE GRENADINES', 'iso3' => 'VCT', 'num_code' => 670, 'phone_code' => 1784],
            ['iso' => 'WS', 'name' => 'Samoa', 'upper_name' => 'SAMOA', 'iso3' => 'WSM', 'num_code' => 882, 'phone_code' => 684],
            ['iso' => 'SM', 'name' => 'San Marino', 'upper_name' => 'SAN MARINO', 'iso3' => 'SMR', 'num_code' => 674, 'phone_code' => 378],
            ['iso' => 'ST', 'name' => 'Sao Tome and Principe', 'upper_name' => 'SAO TOME AND PRINCIPE', 'iso3' => 'STP', 'num_code' => 678, 'phone_code' => 239],
            ['iso' => 'SA', 'name' => 'Saudi Arabia', 'upper_name' => 'SAUDI ARABIA', 'iso3' => 'SAU', 'num_code' => 682, 'phone_code' => 966],
            ['iso' => 'SN', 'name' => 'Senegal', 'upper_name' => 'SEN', 'iso3' => 'SEN', 'num_code' => 686, 'phone_code' => 221],
            ['iso' => 'RS', 'name' => 'Serbia', 'upper_name' => 'SERBIA', 'iso3' => 'SRB', 'num_code' => 688, 'phone_code' => 381],
            ['iso' => 'SC', 'name' => 'Seychelles', 'upper_name' => 'SEYCHELLES', 'iso3' => 'SYC', 'num_code' => 690, 'phone_code' => 248],
            ['iso' => 'SL', 'name' => 'Sierra Leone', 'upper_name' => 'SIERRA LEONE', 'iso3' => 'SLE', 'num_code' => 694, 'phone_code' => 232],
            ['iso' => 'SG', 'name' => 'Singapore', 'upper_name' => 'SINGAPORE', 'iso3' => 'SGP', 'num_code' => 702, 'phone_code' => 65],
            ['iso' => 'SK', 'name' => 'Slovakia', 'upper_name' => 'SLOVAKIA', 'iso3' => 'SVK', 'num_code' => 703, 'phone_code' => 421],
            ['iso' => 'SI', 'name' => 'Slovenia', 'upper_name' => 'SLOVENIA', 'iso3' => 'SVN', 'num_code' => 705, 'phone_code' => 386],
            ['iso' => 'SB', 'name' => 'Solomon Islands', 'upper_name' => 'SOLOMON ISLANDS', 'iso3' => 'SLB', 'num_code' => 90, 'phone_code' => 677],
            ['iso' => 'SO', 'name' => 'Somalia', 'upper_name' => 'SOMALIA', 'iso3' => 'SOM', 'num_code' => 706, 'phone_code' => 252],
            ['iso' => 'ZA', 'name' => 'South Africa', 'upper_name' => 'SOUTH AFRICA', 'iso3' => 'ZAF', 'num_code' => 710, 'phone_code' => 27],
            ['iso' => 'GS', 'name' => 'South Georgia and the South Sandwich Islands', 'upper_name' => 'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS', 'iso3' => 'SGS', 'num_code' => 239, 'phone_code' => 0],
            ['iso' => 'ES', 'name' => 'Spain', 'upper_name' => 'SPAIN', 'iso3' => 'ESP', 'num_code' => 724, 'phone_code' => 34],
            ['iso' => 'LK', 'name' => 'Sri Lanka', 'upper_name' => 'SRI LANKA', 'iso3' => 'LKA', 'num_code' => 144, 'phone_code' => 94],
            ['iso' => 'SD', 'name' => 'Sudan', 'upper_name' => 'SUDAN', 'iso3' => 'SDN', 'num_code' => 736, 'phone_code' => 249],
            ['iso' => 'SR', 'name' => 'Suriname', 'upper_name' => 'SURINAME', 'iso3' => 'SUR', 'num_code' => 740, 'phone_code' => 597],
            ['iso' => 'SJ', 'name' => 'Svalbard and Jan Mayen', 'upper_name' => 'SVALBARD AND JAN MAYEN', 'iso3' => 'SJM', 'num_code' => 744, 'phone_code' => 47],
            ['iso' => 'SZ', 'name' => 'Swaziland', 'upper_name' => 'SWAZILAND', 'iso3' => 'SWZ', 'num_code' => 748, 'phone_code' => 268],
            ['iso' => 'SE', 'name' => 'Sweden', 'upper_name' => 'SWEDEN', 'iso3' => 'SWE', 'num_code' => 752, 'phone_code' => 46],
            ['iso' => 'CH', 'name' => 'Switzerland', 'upper_name' => 'SWITZERLAND', 'iso3' => 'CHE', 'num_code' => 756, 'phone_code' => 41],
            ['iso' => 'SY', 'name' => 'Syrian Arab Republic', 'upper_name' => 'SYRIAN ARAB REPUBLIC', 'iso3' => 'SYR', 'num_code' => 760, 'phone_code' => 963],
            ['iso' => 'TW', 'name' => 'Taiwan, Province of China', 'upper_name' => 'TAIWAN, PROVINCE OF CHINA', 'iso3' => 'TWN', 'num_code' => 158, 'phone_code' => 886],
            ['iso' => 'TJ', 'name' => 'Tajikistan', 'upper_name' => 'TAJIKISTAN', 'iso3' => 'TJK', 'num_code' => 762, 'phone_code' => 992],
            ['iso' => 'TZ', 'name' => 'Tanzania, United Republic of', 'upper_name' => 'TANZANIA, UNITED REPUBLIC OF', 'iso3' => 'TZA', 'num_code' => 834, 'phone_code' => 255],
            ['iso' => 'TH', 'name' => 'Thailand', 'upper_name' => 'THAILAND', 'iso3' => 'THA', 'num_code' => 764, 'phone_code' => 66],
            ['iso' => 'TL', 'name' => 'Timor-Leste', 'upper_name' => 'TIMOR-LESTE', 'iso3' => 'TLS', 'num_code' => 626, 'phone_code' => 670],
            ['iso' => 'TG', 'name' => 'Togo', 'upper_name' => 'TOGO', 'iso3' => 'TGO', 'num_code' => 768, 'phone_code' => 228],
            ['iso' => 'TK', 'name' => 'Tokelau', 'upper_name' => 'TOKELAU', 'iso3' => 'TKL', 'num_code' => 772, 'phone_code' => 690],
            ['iso' => 'TO', 'name' => 'Tonga', 'upper_name' => 'TONGA', 'iso3' => 'TON', 'num_code' => 776, 'phone_code' => 676],
            ['iso' => 'TT', 'name' => 'Trinidad and Tobago', 'upper_name' => 'TRINIDAD AND TOBAGO', 'iso3' => 'TTO', 'num_code' => 780, 'phone_code' => 1868],
            ['iso' => 'TN', 'name' => 'Tunisia', 'upper_name' => 'TUNISIA', 'iso3' => 'TUN', 'num_code' => 788, 'phone_code' => 216],
            ['iso' => 'TR', 'name' => 'Turkey', 'upper_name' => 'TURKEY', 'iso3' => 'TUR', 'num_code' => 792, 'phone_code' => 90],
            ['iso' => 'TM', 'name' => 'Turkmenistan', 'upper_name' => 'TURKMENISTAN', 'iso3' => 'TKM', 'num_code' => 795, 'phone_code' => 993],
            ['iso' => 'TC', 'name' => 'Turks and Caicos Islands', 'upper_name' => 'TURKS AND CAICOS ISLANDS', 'iso3' => 'TCA', 'num_code' => 796, 'phone_code' => 1649],
            ['iso' => 'TV', 'name' => 'Tuvalu', 'upper_name' => 'TUVALU', 'iso3' => 'TUV', 'num_code' => 798, 'phone_code' => 688],
            ['iso' => 'UG', 'name' => 'Uganda', 'upper_name' => 'UGANDA', 'iso3' => 'UGA', 'num_code' => 800, 'phone_code' => 256],
            ['iso' => 'UA', 'name' => 'Ukraine', 'upper_name' => 'UKRAINE', 'iso3' => 'UKR', 'num_code' => 804, 'phone_code' => 380],
            ['iso' => 'AE', 'name' => 'United Arab Emirates', 'upper_name' => 'UNITED ARAB EMIRATES', 'iso3' => 'ARE', 'num_code' => 784, 'phone_code' => 971],
            ['iso' => 'GB', 'name' => 'United Kingdom', 'upper_name' => 'UNITED KINGDOM', 'iso3' => 'GBR', 'num_code' => 826, 'phone_code' => 44],
            ['iso' => 'US', 'name' => 'United States', 'upper_name' => 'UNITED STATES', 'iso3' => 'USA', 'num_code' => 840, 'phone_code' => 1],
            ['iso' => 'UM', 'name' => 'United States Minor Outlying Islands', 'upper_name' => 'UNITED STATES MINOR OUTLYING ISLANDS', 'iso3' => 'UMI', 'num_code' => 581, 'phone_code' => 1],
            ['iso' => 'UY', 'name' => 'Uruguay', 'upper_name' => 'URUGUAY', 'iso3' => 'URY', 'num_code' => 858, 'phone_code' => 598],
            ['iso' => 'UZ', 'name' => 'Uzbekistan', 'upper_name' => 'UZBEKISTAN', 'iso3' => 'UZB', 'num_code' => 860, 'phone_code' => 998],
            ['iso' => 'VU', 'name' => 'Vanuatu', 'upper_name' => 'VANUATU', 'iso3' => 'VUT', 'num_code' => 548, 'phone_code' => 678],
            ['iso' => 'VE', 'name' => 'Venezuela', 'upper_name' => 'VENEZUELA', 'iso3' => 'VEN', 'num_code' => 862, 'phone_code' => 58],
            ['iso' => 'VN', 'name' => 'Viet Nam', 'upper_name' => 'VIET NAM', 'iso3' => 'VNM', 'num_code' => 704, 'phone_code' => 84],
            ['iso' => 'VG', 'name' => 'Virgin Islands, British', 'upper_name' => 'VIRGIN ISLANDS, BRITISH', 'iso3' => 'VGB', 'num_code' => 92, 'phone_code' => 1284],
            ['iso' => 'VI', 'name' => 'Virgin Islands, U.S.', 'upper_name' => 'VIRGIN ISLANDS, U.S.', 'iso3' => 'VIR', 'num_code' => 850, 'phone_code' => 1340],
            ['iso' => 'WF', 'name' => 'Wallis and Futuna', 'upper_name' => 'WALLIS AND FUTUNA', 'iso3' => 'WLF', 'num_code' => 876, 'phone_code' => 681],
            ['iso' => 'EH', 'name' => 'Western Sahara', 'upper_name' => 'WESTERN SAHARA', 'iso3' => 'ESH', 'num_code' => 732, 'phone_code' => 212],
            ['iso' => 'YE', 'name' => 'Yemen', 'upper_name' => 'YEMEN', 'iso3' => 'YEM', 'num_code' => 887, 'phone_code' => 967],
            ['iso' => 'ZM', 'name' => 'Zambia', 'upper_name' => 'ZAMBIA', 'iso3' => 'ZMB', 'num_code' => 894, 'phone_code' => 260],
            ['iso' => 'ZW', 'name' => 'Zimbabwe', 'upper_name' => 'ZIMBABWE', 'iso3' => 'ZWE', 'num_code' => 716, 'phone_code' => 263],
            ['iso' => 'ME', 'name' => 'Montenegro', 'upper_name' => 'MONTENEGRO', 'iso3' => 'MNE', 'num_code' => 499, 'phone_code' => 382],
            ['iso' => 'XK', 'name' => 'Kosovo', 'upper_name' => 'KOSOVO', 'iso3' => 'XKX', 'num_code' => 0, 'phone_code' => 383],
            ['iso' => 'AX', 'name' => 'Aland Islands', 'upper_name' => 'ALAND ISLANDS', 'iso3' => 'ALA', 'num_code' => 248, 'phone_code' => 358],
            ['iso' => 'BQ', 'name' => 'Bonaire, Sint Eustatius and Saba', 'upper_name' => 'BONAIRE, SINT EUSTATIUS AND SABA', 'iso3' => 'BES', 'num_code' => 535, 'phone_code' => 599],
            ['iso' => 'CW', 'name' => 'Curacao', 'upper_name' => 'CURACAO', 'iso3' => 'CUW', 'num_code' => 531, 'phone_code' => 599],
            ['iso' => 'GG', 'name' => 'Guernsey', 'upper_name' => 'GUERNSEY', 'iso3' => 'GGY', 'num_code' => 831, 'phone_code' => 44],
            ['iso' => 'IM', 'name' => 'Isle of Man', 'upper_name' => 'ISLE OF MAN', 'iso3' => 'IMN', 'num_code' => 833, 'phone_code' => 44],
            ['iso' => 'JE', 'name' => 'Jersey', 'upper_name' => 'JERSEY', 'iso3' => 'JEY', 'num_code' => 832, 'phone_code' => 44],
            ['iso' => 'BL', 'name' => 'Saint Barthelemy', 'upper_name' => 'SAINT BARTHELEMY', 'iso3' => 'BLM', 'num_code' => 652, 'phone_code' => 590],
            ['iso' => 'MF', 'name' => 'Saint Martin', 'upper_name' => 'SAINT MARTIN', 'iso3' => 'MAF', 'num_code' => 663, 'phone_code' => 590],
            ['iso' => 'SX', 'name' => 'Sint Maarten', 'upper_name' => 'SINT MAARTEN', 'iso3' => 'SXM', 'num_code' => 534, 'phone_code' => 1],
            ['iso' => 'SS', 'name' => 'South Sudan', 'upper_name' => 'SOUTH SUDAN', 'iso3' => 'SSD', 'num_code' => 728, 'phone_code' => 211],
        ];
        foreach ($countries_part2 as $country) {
            Country::create($country);
        }

        // Countries - Part 3
        $countries_part3 = [
            ['iso' => 'AC', 'name' => 'Ascension Island', 'upper_name' => 'ASCENSION ISLAND', 'iso3' => null, 'num_code' => null, 'phone_code' => 247],
            ['iso' => 'CP', 'name' => 'Clipperton Island', 'upper_name' => 'CLIPPERTON ISLAND', 'iso3' => null, 'num_code' => null, 'phone_code' => 0],
            ['iso' => 'DG', 'name' => 'Diego Garcia', 'upper_name' => 'DIEGO GARCIA', 'iso3' => null, 'num_code' => null, 'phone_code' => 246],
            ['iso' => 'EA', 'name' => 'Ceuta & Melilla', 'upper_name' => 'CEUTA & MELILLA', 'iso3' => null, 'num_code' => null, 'phone_code' => 34],
            ['iso' => 'EZ', 'name' => 'Eurozone', 'upper_name' => 'EUROZONE', 'iso3' => null, 'num_code' => null, 'phone_code' => 0],
            ['iso' => 'TA', 'name' => 'Tristan da Cunha', 'upper_name' => 'TRISTAN DA CUNHA', 'iso3' => null, 'num_code' => null, 'phone_code' => 290],
            ['iso' => 'AQ', 'name' => 'Antarctica', 'upper_name' => 'ANTARCTICA', 'iso3' => 'ATA', 'num_code' => 10, 'phone_code' => 0],
            ['iso' => 'BV', 'name' => 'Bouvet Island', 'upper_name' => 'BOUVET ISLAND', 'iso3' => 'BVT', 'num_code' => 74, 'phone_code' => 0],
            ['iso' => 'IO', 'name' => 'British Indian Ocean Territory', 'upper_name' => 'BRITISH INDIAN OCEAN TERRITORY', 'iso3' => 'IOT', 'num_code' => 86, 'phone_code' => 246],
            ['iso' => 'CX', 'name' => 'Christmas Island', 'upper_name' => 'CHRISTMAS ISLAND', 'iso3' => 'CXR', 'num_code' => 162, 'phone_code' => 61],
            ['iso' => 'CC', 'name' => 'Cocos (Keeling) Islands', 'upper_name' => 'COCOS (KEELING) ISLANDS', 'iso3' => 'CCK', 'num_code' => 166, 'phone_code' => 672],
            ['iso' => 'HM', 'name' => 'Heard Island and McDonald Islands', 'upper_name' => 'HEARD ISLAND AND MCDONALD ISLANDS', 'iso3' => 'HMD', 'num_code' => 334, 'phone_code' => 0],
            ['iso' => 'NF', 'name' => 'Norfolk Island', 'upper_name' => 'NORFOLK ISLAND', 'iso3' => 'NFK', 'num_code' => 574, 'phone_code' => 672],
            ['iso' => 'MP', 'name' => 'Northern Mariana Islands', 'upper_name' => 'NORTHERN MARIANA ISLANDS', 'iso3' => 'MNP', 'num_code' => 580, 'phone_code' => 1670],
            ['iso' => 'PN', 'name' => 'Pitcairn', 'upper_name' => 'PITCAIRN', 'iso3' => 'PCN', 'num_code' => 612, 'phone_code' => 0],
            ['iso' => 'GS', 'name' => 'South Georgia and the South Sandwich Islands', 'upper_name' => 'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS', 'iso3' => 'SGS', 'num_code' => 239, 'phone_code' => 0],
            ['iso' => 'SJ', 'name' => 'Svalbard and Jan Mayen', 'upper_name' => 'SVALBARD AND JAN MAYEN', 'iso3' => 'SJM', 'num_code' => 744, 'phone_code' => 47],
            ['iso' => 'TC', 'name' => 'Turks and Caicos Islands', 'upper_name' => 'TURKS AND CAICOS ISLANDS', 'iso3' => 'TCA', 'num_code' => 796, 'phone_code' => 1649],
            ['iso' => 'UM', 'name' => 'United States Minor Outlying Islands', 'upper_name' => 'UNITED STATES MINOR OUTLYING ISLANDS', 'iso3' => 'UMI', 'num_code' => 581, 'phone_code' => 1],
            ['iso' => 'VG', 'name' => 'Virgin Islands, British', 'upper_name' => 'VIRGIN ISLANDS, BRITISH', 'iso3' => 'VGB', 'num_code' => 92, 'phone_code' => 1284],
            ['iso' => 'VI', 'name' => 'Virgin Islands, U.S.', 'upper_name' => 'VIRGIN ISLANDS, U.S.', 'iso3' => 'VIR', 'num_code' => 850, 'phone_code' => 1340],
            ['iso' => 'WF', 'name' => 'Wallis and Futuna', 'upper_name' => 'WALLIS AND FUTUNA', 'iso3' => 'WLF', 'num_code' => 876, 'phone_code' => 681],
            ['iso' => 'EH', 'name' => 'Western Sahara', 'upper_name' => 'WESTERN SAHARA', 'iso3' => 'ESH', 'num_code' => 732, 'phone_code' => 212],
        ];
        foreach ($countries_part3 as $country) {
            Country::create($country);
        }

        // Countries - Part 4
        $countries_part4 = [
            ['iso' => 'BQ', 'name' => 'Bonaire, Sint Eustatius and Saba', 'upper_name' => 'BONAIRE, SINT EUSTATIUS AND SABA', 'iso3' => 'BES', 'num_code' => 535, 'phone_code' => 599],
            ['iso' => 'CW', 'name' => 'Curacao', 'upper_name' => 'CURACAO', 'iso3' => 'CUW', 'num_code' => 531, 'phone_code' => 599],
            ['iso' => 'GG', 'name' => 'Guernsey', 'upper_name' => 'GUERNSEY', 'iso3' => 'GGY', 'num_code' => 831, 'phone_code' => 44],
            ['iso' => 'IM', 'name' => 'Isle of Man', 'upper_name' => 'ISLE OF MAN', 'iso3' => 'IMN', 'num_code' => 833, 'phone_code' => 44],
            ['iso' => 'JE', 'name' => 'Jersey', 'upper_name' => 'JERSEY', 'iso3' => 'JEY', 'num_code' => 832, 'phone_code' => 44],
            ['iso' => 'BL', 'name' => 'Saint Barthelemy', 'upper_name' => 'SAINT BARTHELEMY', 'iso3' => 'BLM', 'num_code' => 652, 'phone_code' => 590],
            ['iso' => 'MF', 'name' => 'Saint Martin', 'upper_name' => 'SAINT MARTIN', 'iso3' => 'MAF', 'num_code' => 663, 'phone_code' => 590],
            ['iso' => 'SX', 'name' => 'Sint Maarten', 'upper_name' => 'SINT MAARTEN', 'iso3' => 'SXM', 'num_code' => 534, 'phone_code' => 1],
            ['iso' => 'SS', 'name' => 'South Sudan', 'upper_name' => 'SOUTH SUDAN', 'iso3' => 'SSD', 'num_code' => 728, 'phone_code' => 211],
        ];
        foreach ($countries_part4 as $country) {
            Country::create($country);
        }
    }
}
