@php
    // echo "user";
    // print_r($user);die;
@endphp
@extends('admin.layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>User Update</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                            <li class="breadcrumb-item active">Edit User</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">

                        <ul>
                            @foreach ($errors->all() as $error)
                                <button type="button" class="btn btn-warning toastsDefaultWarning">
                                    {{ $error }}
                                </button>
                            @endforeach
                        </ul>

                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Update User</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form action="{{ route('update.User', [encrypt($user->id)]) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control" id="name"
                                                placeholder="Enter name" name="name" value="{{ $user->name }}"
                                                required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="username">Username</label>
                                            <input type="text" class="form-control"
                                                id="usernsme"placeholder="Enter username" name="username"
                                                value="{{ $user->username }}" required>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" id="email"
                                                placeholder="Enter email" name="email" value="{{ $user->email }}"
                                                required>
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="countryCode">Phone Code</label>
                                            <select name="countryCode" id="countryCode" class="form-control">
                                                {{-- <option data-countryCode="GB" value="44" Selected>UK (+44)</option>
                                                <option data-countryCode="US" value="1">USA (+1)</option> --}}
                                                {{-- <optgroup label="Other countries"> --}}
                                                    <option data-countryCode="DZ" value="213" {{ "213" == $countryCode ? 'selected' : '' }}>Algeria (+213)</option>
                                                    <option data-countryCode="AD" value="376" {{ "376" == $countryCode ? 'selected' : '' }}>Andorra (+376)</option>
                                                    <option data-countryCode="AO" value="244" {{ "244" == $countryCode ? 'selected' : '' }}>Angola (+244)</option>
                                                    <option data-countryCode="AI" value="1264" {{ "1264" == $countryCode ? 'selected' : '' }}>Anguilla (+1264)</option>
                                                    <option data-countryCode="AG" value="1268" {{ "1268" == $countryCode ? 'selected' : '' }}>Antigua &amp; Barbuda (+1268)</option>
                                                    <option data-countryCode="AR" value="54" {{ "54" == $countryCode ? 'selected' : '' }}>Argentina (+54)</option>
                                                    <option data-countryCode="AM" value="374" {{ "374" == $countryCode ? 'selected' : '' }}>Armenia (+374)</option>
                                                    <option data-countryCode="AW" value="297" {{ "297" == $countryCode ? 'selected' : '' }}>Aruba (+297)</option>
                                                    <option data-countryCode="AU" value="61" {{ "61" == $countryCode ? 'selected' : '' }}>Australia (+61)</option>
                                                    <option data-countryCode="AT" value="43" {{ "43" == $countryCode ? 'selected' : '' }}>Austria (+43)</option>
                                                    <option data-countryCode="AZ" value="994" {{ "994" == $countryCode ? 'selected' : '' }}>Azerbaijan (+994)</option>
                                                    <option data-countryCode="BS" value="1242" {{ "1242" == $countryCode ? 'selected' : '' }}>Bahamas (+1242)</option>
                                                    <option data-countryCode="BH" value="973" {{ "973" == $countryCode ? 'selected' : '' }}>Bahrain (+973)</option>
                                                    <option data-countryCode="BD" value="880" {{ "880" == $countryCode ? 'selected' : '' }}>Bangladesh (+880)</option>
                                                    <option data-countryCode="BB" value="1246" {{ "1246" == $countryCode ? 'selected' : '' }}>Barbados (+1246)</option>
                                                    <option data-countryCode="BY" value="375" {{ "375" == $countryCode ? 'selected' : '' }}>Belarus (+375)</option>
                                                    <option data-countryCode="BE" value="32" {{ "32" == $countryCode ? 'selected' : '' }}>Belgium (+32)</option>
                                                    <option data-countryCode="BZ" value="501" {{ "501" == $countryCode ? 'selected' : '' }}>Belize (+501)</option>
                                                    <option data-countryCode="BJ" value="229" {{ "229" == $countryCode ? 'selected' : '' }}>Benin (+229)</option>
                                                    <option data-countryCode="BM" value="1441" {{ "1441" == $countryCode ? 'selected' : '' }}>Bermuda (+1441)</option>
                                                    <option data-countryCode="BT" value="975" {{ "975" == $countryCode ? 'selected' : '' }}>Bhutan (+975)</option>
                                                    <option data-countryCode="BO" value="591" {{ "591" == $countryCode ? 'selected' : '' }}>Bolivia (+591)</option>
                                                    <option data-countryCode="BA" value="387" {{ "387" == $countryCode ? 'selected' : '' }}>Bosnia Herzegovina (+387)</option>
                                                    <option data-countryCode="BW" value="267" {{ "267" == $countryCode ? 'selected' : '' }}>Botswana (+267)</option>
                                                    <option data-countryCode="BR" value="55" {{ "55" == $countryCode ? 'selected' : '' }}>Brazil (+55)</option>
                                                    <option data-countryCode="BN" value="673" {{ "673" == $countryCode ? 'selected' : '' }}>Brunei (+673)</option>
                                                    <option data-countryCode="BG" value="359" {{ "359" == $countryCode ? 'selected' : '' }}>Bulgaria (+359)</option>
                                                    <option data-countryCode="BF" value="226" {{ "226" == $countryCode ? 'selected' : '' }}>Burkina Faso (+226)</option>
                                                    <option data-countryCode="BI" value="257" {{ "257" == $countryCode ? 'selected' : '' }}>Burundi (+257)</option>
                                                    <option data-countryCode="KH" value="855" {{ "855" == $countryCode ? 'selected' : '' }}>Cambodia (+855)</option>
                                                    <option data-countryCode="CM" value="237" {{ "237" == $countryCode ? 'selected' : '' }}>Cameroon (+237)</option>
                                                    <option data-countryCode="CA" value="1" {{ "1" == $countryCode ? 'selected' : '' }}>Canada (+1)</option>
                                                    <option data-countryCode="CV" value="238" {{ "238" == $countryCode ? 'selected' : '' }}>Cape Verde Islands (+238)</option>
                                                    <option data-countryCode="KY" value="1345" {{ "1345" == $countryCode ? 'selected' : '' }}>Cayman Islands (+1345)</option>
                                                    <option data-countryCode="CF" value="236" {{ "236" == $countryCode ? 'selected' : '' }}>Central African Republic (+236)</option>
                                                    <option data-countryCode="CL" value="56" {{ "56" == $countryCode ? 'selected' : '' }}>Chile (+56)</option>
                                                    <option data-countryCode="CN" value="86" {{ "86" == $countryCode ? 'selected' : '' }}>China (+86)</option>
                                                    <option data-countryCode="CO" value="57" {{ "57" == $countryCode ? 'selected' : '' }}>Colombia (+57)</option>
                                                    <option data-countryCode="KM" value="269" {{ "269" == $countryCode ? 'selected' : '' }}>Comoros (+269)</option>
                                                    <option data-countryCode="CG" value="242" {{ "242" == $countryCode ? 'selected' : '' }}>Congo (+242)</option>
                                                    <option data-countryCode="CK" value="682" {{ "682" == $countryCode ? 'selected' : '' }}>Cook Islands (+682)</option>
                                                    <option data-countryCode="CR" value="506" {{ "506" == $countryCode ? 'selected' : '' }}>Costa Rica (+506)</option>
                                                    <option data-countryCode="HR" value="385" {{ "385" == $countryCode ? 'selected' : '' }}>Croatia (+385)</option>
                                                    <option data-countryCode="CU" value="53" {{ "53" == $countryCode ? 'selected' : '' }}>Cuba (+53)</option>
                                                    <option data-countryCode="CY" value="90392" {{ "90392" == $countryCode ? 'selected' : '' }}>Cyprus North (+90392)</option>
                                                    <option data-countryCode="CY" value="357" {{ "357" == $countryCode ? 'selected' : '' }}>Cyprus South (+357)</option>
                                                    <option data-countryCode="CZ" value="42" {{ "42" == $countryCode ? 'selected' : '' }}>Czech Republic (+42)</option>
                                                    <option data-countryCode="DK" value="45" {{ "45" == $countryCode ? 'selected' : '' }}>Denmark (+45)</option>
                                                    <option data-countryCode="DJ" value="253" {{ "253" == $countryCode ? 'selected' : '' }}>Djibouti (+253)</option>
                                                    <option data-countryCode="DM" value="1809" {{ "1809" == $countryCode ? 'selected' : '' }}>Dominica (+1809)</option>
                                                    {{-- <option data-countryCode="DO" value="1809" {{ "1809" == $countryCode ? 'selected' : '' }}>Dominican Republic (+1809)</option> --}}
                                                    <option data-countryCode="EC" value="593" {{ "593" == $countryCode ? 'selected' : '' }}>Ecuador (+593)</option>
                                                    <option data-countryCode="EG" value="20" {{ "20" == $countryCode ? 'selected' : '' }}>Egypt (+20)</option>
                                                    <option data-countryCode="SV" value="503" {{ "503" == $countryCode ? 'selected' : '' }}>El Salvador (+503)</option>
                                                    <option data-countryCode="GQ" value="240" {{ "240" == $countryCode ? 'selected' : '' }}>Equatorial Guinea (+240)</option>
                                                    <option data-countryCode="ER" value="291" {{ "291" == $countryCode ? 'selected' : '' }}>Eritrea (+291)</option>
                                                    <option data-countryCode="EE" value="372" {{ "372" == $countryCode ? 'selected' : '' }}>Estonia (+372)</option>
                                                    <option data-countryCode="ET" value="251" {{ "251" == $countryCode ? 'selected' : '' }}>Ethiopia (+251)</option>
                                                    <option data-countryCode="FK" value="500" {{ "500" == $countryCode ? 'selected' : '' }}>Falkland Islands (+500)</option>
                                                    <option data-countryCode="FO" value="298" {{ "298" == $countryCode ? 'selected' : '' }}>Faroe Islands (+298)</option>
                                                    <option data-countryCode="FJ" value="679" {{ "679" == $countryCode ? 'selected' : '' }}>Fiji (+679)</option>
                                                    <option data-countryCode="FI" value="358" {{ "358" == $countryCode ? 'selected' : '' }}>Finland (+358)</option>
                                                    <option data-countryCode="FR" value="33" {{ "33" == $countryCode ? 'selected' : '' }}>France (+33)</option>
                                                    <option data-countryCode="GF" value="594" {{ "594" == $countryCode ? 'selected' : '' }}>French Guiana (+594)</option>
                                                    <option data-countryCode="PF" value="689" {{ "689" == $countryCode ? 'selected' : '' }}>French Polynesia (+689)</option>
                                                    <option data-countryCode="GA" value="241" {{ "241" == $countryCode ? 'selected' : '' }}>Gabon (+241)</option>
                                                    <option data-countryCode="GM" value="220" {{ "220" == $countryCode ? 'selected' : '' }}>Gambia (+220)</option>
                                                    <option data-countryCode="GE" value="7880" {{ "7880" == $countryCode ? 'selected' : '' }}>Georgia (+7880)</option>
                                                    <option data-countryCode="DE" value="49" {{ "49" == $countryCode ? 'selected' : '' }}>Germany (+49)</option>
                                                    <option data-countryCode="GH" value="233" {{ "233" == $countryCode ? 'selected' : '' }}>Ghana (+233)</option>
                                                    <option data-countryCode="GI" value="350" {{ "350" == $countryCode ? 'selected' : '' }}>Gibraltar (+350)</option>
                                                    <option data-countryCode="GR" value="30" {{ "30" == $countryCode ? 'selected' : '' }}>Greece (+30)</option>
                                                    <option data-countryCode="GL" value="299" {{ "299" == $countryCode ? 'selected' : '' }}>Greenland (+299)</option>
                                                    <option data-countryCode="GD" value="1473" {{ "1473" == $countryCode ? 'selected' : '' }}>Grenada (+1473)</option>
                                                    <option data-countryCode="GP" value="590" {{ "590" == $countryCode ? 'selected' : '' }}>Guadeloupe (+590)</option>
                                                    <option data-countryCode="GU" value="671" {{ "671" == $countryCode ? 'selected' : '' }}>Guam (+671)</option>
                                                    <option data-countryCode="GT" value="502" {{ "502" == $countryCode ? 'selected' : '' }}>Guatemala (+502)</option>
                                                    <option data-countryCode="GN" value="224" {{ "224" == $countryCode ? 'selected' : '' }}>Guinea (+224)</option>
                                                    <option data-countryCode="GW" value="245" {{ "245" == $countryCode ? 'selected' : '' }}>Guinea - Bissau (+245)</option>
                                                    <option data-countryCode="GY" value="592" {{ "592" == $countryCode ? 'selected' : '' }}>Guyana (+592)</option>
                                                    <option data-countryCode="HT" value="509" {{ "509" == $countryCode ? 'selected' : '' }}>Haiti (+509)</option>
                                                    <option data-countryCode="HN" value="504" {{ "504" == $countryCode ? 'selected' : '' }}>Honduras (+504)</option>
                                                    <option data-countryCode="HK" value="852" {{ "852" == $countryCode ? 'selected' : '' }}>Hong Kong (+852)</option>
                                                    <option data-countryCode="HU" value="36" {{ "36" == $countryCode ? 'selected' : '' }}>Hungary (+36)</option>
                                                    <option data-countryCode="IS" value="354" {{ "354" == $countryCode ? 'selected' : '' }}>Iceland (+354)</option>
                                                    <option data-countryCode="IN" value="91" {{ "91" == $countryCode ? 'selected' : '' }}>India (+91)</option>
                                                    <option data-countryCode="ID" value="62" {{ "62" == $countryCode ? 'selected' : '' }}>Indonesia (+62)</option>
                                                    <option data-countryCode="IR" value="98" {{ "98" == $countryCode ? 'selected' : '' }}>Iran (+98)</option>
                                                    <option data-countryCode="IQ" value="964" {{ "964" == $countryCode ? 'selected' : '' }}>Iraq (+964)</option>
                                                    <option data-countryCode="IE" value="353" {{ "353" == $countryCode ? 'selected' : '' }}>Ireland (+353)</option>
                                                    <option data-countryCode="IL" value="972" {{ "972" == $countryCode ? 'selected' : '' }}>Israel (+972)</option>
                                                    <option data-countryCode="IT" value="39" {{ "39" == $countryCode ? 'selected' : '' }}>Italy (+39)</option>
                                                    <option data-countryCode="JM" value="1876" {{ "1876" == $countryCode ? 'selected' : '' }}>Jamaica (+1876)</option>
                                                    <option data-countryCode="JP" value="81" {{ "81" == $countryCode ? 'selected' : '' }}>Japan (+81)</option>
                                                    <option data-countryCode="JO" value="962" {{ "962" == $countryCode ? 'selected' : '' }}>Jordan (+962)</option>
                                                    <option data-countryCode="KZ" value="7" {{ "7" == $countryCode ? 'selected' : '' }}>Kazakhstan (+7)</option>
                                                    <option data-countryCode="KE" value="254" {{ "254" == $countryCode ? 'selected' : '' }}>Kenya (+254)</option>
                                                    <option data-countryCode="KI" value="686" {{ "686" == $countryCode ? 'selected' : '' }}>Kiribati (+686)</option>
                                                    <option data-countryCode="KP" value="850" {{ "850" == $countryCode ? 'selected' : '' }}>Korea North (+850)</option>
                                                    <option data-countryCode="KR" value="82" {{ "82" == $countryCode ? 'selected' : '' }}>Korea South (+82)</option>
                                                    <option data-countryCode="KW" value="965" {{ "965" == $countryCode ? 'selected' : '' }}>Kuwait (+965)</option>
                                                    <option data-countryCode="KG" value="996" {{ "996" == $countryCode ? 'selected' : '' }}>Kyrgyzstan (+996)</option>
                                                    <option data-countryCode="LA" value="856" {{ "856" == $countryCode ? 'selected' : '' }}>Laos (+856)</option>
                                                    <option data-countryCode="LV" value="371" {{ "371" == $countryCode ? 'selected' : '' }}>Latvia (+371)</option>
                                                    <option data-countryCode="LB" value="961" {{ "961" == $countryCode ? 'selected' : '' }}>Lebanon (+961)</option>
                                                    <option data-countryCode="LS" value="266" {{ "266" == $countryCode ? 'selected' : '' }}>Lesotho (+266)</option>
                                                    <option data-countryCode="LR" value="231" {{ "231" == $countryCode ? 'selected' : '' }}>Liberia (+231)</option>
                                                    <option data-countryCode="LY" value="218" {{ "218" == $countryCode ? 'selected' : '' }}>Libya (+218)</option>
                                                    <option data-countryCode="LI" value="417" {{ "417" == $countryCode ? 'selected' : '' }}>Liechtenstein (+417)</option>
                                                    <option data-countryCode="LT" value="370" {{ "370" == $countryCode ? 'selected' : '' }}>Lithuania (+370)</option>
                                                    <option data-countryCode="LU" value="352">Luxembourg (+352)</option>
                                                    <option data-countryCode="MO" value="853" {{ "853" == $countryCode ? 'selected' : '' }}>Macao (+853)</option>
                                                    <option data-countryCode="MK" value="389" {{ "389" == $countryCode ? 'selected' : '' }}>Macedonia (+389)</option>
                                                    <option data-countryCode="MG" value="261" {{ "261" == $countryCode ? 'selected' : '' }}>Madagascar (+261)</option>
                                                    <option data-countryCode="MW" value="265" {{ "265" == $countryCode ? 'selected' : '' }}>Malawi (+265)</option>
                                                    <option data-countryCode="MY" value="60" {{ "60" == $countryCode ? 'selected' : '' }}>Malaysia (+60)</option>
                                                    <option data-countryCode="MV" value="960" {{ "960" == $countryCode ? 'selected' : '' }}>Maldives (+960)</option>
                                                    <option data-countryCode="ML" value="223" {{ "223" == $countryCode ? 'selected' : '' }}>Mali (+223)</option>
                                                    <option data-countryCode="MT" value="356" {{ "356" == $countryCode ? 'selected' : '' }}>Malta (+356)</option>
                                                    <option data-countryCode="MH" value="692" {{ "692" == $countryCode ? 'selected' : '' }}>Marshall Islands (+692)</option>
                                                    <option data-countryCode="MQ" value="596" {{ "596" == $countryCode ? 'selected' : '' }}>Martinique (+596)</option>
                                                    <option data-countryCode="MR" value="222" {{ "222" == $countryCode ? 'selected' : '' }}>Mauritania (+222)</option>
                                                    <option data-countryCode="YT" value="269" {{ "269" == $countryCode ? 'selected' : '' }}>Mayotte (+269)</option>
                                                    <option data-countryCode="MX" value="52" {{ "52" == $countryCode ? 'selected' : '' }}>Mexico (+52)</option>
                                                    <option data-countryCode="FM" value="691" {{ "691" == $countryCode ? 'selected' : '' }}>Micronesia (+691)</option>
                                                    <option data-countryCode="MD" value="373" {{ "373" == $countryCode ? 'selected' : '' }}>Moldova (+373)</option>
                                                    <option data-countryCode="MC" value="377" {{ "377" == $countryCode ? 'selected' : '' }}>Monaco (+377)</option>
                                                    <option data-countryCode="MN" value="976" {{ "976" == $countryCode ? 'selected' : '' }}>Mongolia (+976)</option>
                                                    <option data-countryCode="MS" value="1664" {{ "1664" == $countryCode ? 'selected' : '' }}>Montserrat (+1664)</option>
                                                    <option data-countryCode="MA" value="212" {{ "212" == $countryCode ? 'selected' : '' }}>Morocco (+212)</option>
                                                    <option data-countryCode="MZ" value="258" {{ "258" == $countryCode ? 'selected' : '' }}>Mozambique (+258)</option>
                                                    <option data-countryCode="MN" value="95" {{ "95" == $countryCode ? 'selected' : '' }}>Myanmar (+95)</option>
                                                    <option data-countryCode="NA" value="264" {{ "264" == $countryCode ? 'selected' : '' }}>Namibia (+264)</option>
                                                    <option data-countryCode="NR" value="674" {{ "674" == $countryCode ? 'selected' : '' }}>Nauru (+674)</option>
                                                    <option data-countryCode="NP" value="977" {{ "977" == $countryCode ? 'selected' : '' }}>Nepal (+977)</option>
                                                    <option data-countryCode="NL" value="31" {{ "31" == $countryCode ? 'selected' : '' }}>Netherlands (+31)</option>
                                                    <option data-countryCode="NC" value="687" {{ "687" == $countryCode ? 'selected' : '' }}>New Caledonia (+687)</option>
                                                    <option data-countryCode="NZ" value="64" {{ "64" == $countryCode ? 'selected' : '' }}>New Zealand (+64)</option>
                                                    <option data-countryCode="NI" value="505" {{ "505" == $countryCode ? 'selected' : '' }}>Nicaragua (+505)</option>
                                                    <option data-countryCode="NE" value="227" {{ "227" == $countryCode ? 'selected' : '' }}>Niger (+227)</option>
                                                    <option data-countryCode="NG" value="234" {{ "234" == $countryCode ? 'selected' : '' }}>Nigeria (+234)</option>
                                                    <option data-countryCode="NU" value="683" {{ "683" == $countryCode ? 'selected' : '' }}>Niue (+683)</option>
                                                    <option data-countryCode="NF" value="672" {{ "672" == $countryCode ? 'selected' : '' }}>Norfolk Islands (+672)</option>
                                                    <option data-countryCode="NP" value="670" {{ "670" == $countryCode ? 'selected' : '' }}>Northern Marianas (+670)</option>
                                                    <option data-countryCode="NO" value="47" {{ "47" == $countryCode ? 'selected' : '' }}>Norway (+47)</option>
                                                    <option data-countryCode="OM" value="968" {{ "968" == $countryCode ? 'selected' : '' }}>Oman (+968)</option>
                                                    <option data-countryCode="PW" value="680" {{ "680" == $countryCode ? 'selected' : '' }}>Palau (+680)</option>
                                                    <option data-countryCode="PA" value="507" {{ "507" == $countryCode ? 'selected' : '' }}>Panama (+507)</option>
                                                    <option data-countryCode="PG" value="675" {{ "675" == $countryCode ? 'selected' : '' }}>Papua New Guinea (+675)</option>
                                                    <option data-countryCode="PY" value="595" {{ "595" == $countryCode ? 'selected' : '' }}>Paraguay (+595)</option>
                                                    <option data-countryCode="PE" value="51" {{ "51" == $countryCode ? 'selected' : '' }}>Peru (+51)</option>
                                                    <option data-countryCode="PH" value="63" {{ "63" == $countryCode ? 'selected' : '' }}>Philippines (+63)</option>
                                                    <option data-countryCode="PL" value="48" {{ "48" == $countryCode ? 'selected' : '' }}>Poland (+48)</option>
                                                    <option data-countryCode="PT" value="351" {{ "351" == $countryCode ? 'selected' : '' }}>Portugal (+351)</option>
                                                    <option data-countryCode="PR" value="1787" {{ "1787" == $countryCode ? 'selected' : '' }}>Puerto Rico (+1787)</option>
                                                    <option data-countryCode="QA" value="974" {{ "974" == $countryCode ? 'selected' : '' }}>Qatar (+974)</option>
                                                    <option data-countryCode="RE" value="262" {{ "262" == $countryCode ? 'selected' : '' }}>Reunion (+262)</option>
                                                    <option data-countryCode="RO" value="40" {{ "40" == $countryCode ? 'selected' : '' }}>Romania (+40)</option>
                                                    <option data-countryCode="RU" value="7" {{ "7" == $countryCode ? 'selected' : '' }}>Russia (+7)</option>
                                                    <option data-countryCode="RW" value="250" {{ "250" == $countryCode ? 'selected' : '' }}>Rwanda (+250)</option>
                                                    <option data-countryCode="SM" value="378" {{ "378" == $countryCode ? 'selected' : '' }}>San Marino (+378)</option>
                                                    <option data-countryCode="ST" value="239" {{ "239" == $countryCode ? 'selected' : '' }}>Sao Tome &amp; Principe (+239)</option>
                                                    <option data-countryCode="SA" value="966" {{ "966" == $countryCode ? 'selected' : '' }}>Saudi Arabia (+966)</option>
                                                    <option data-countryCode="SN" value="221" {{ "221" == $countryCode ? 'selected' : '' }}>Senegal (+221)</option>
                                                    <option data-countryCode="CS" value="381" {{ "381" == $countryCode ? 'selected' : '' }}>Serbia (+381)</option>
                                                    <option data-countryCode="SC" value="248" {{ "248" == $countryCode ? 'selected' : '' }}>Seychelles (+248)</option>
                                                    <option data-countryCode="SL" value="232" {{ "232" == $countryCode ? 'selected' : '' }}>Sierra Leone (+232)</option>
                                                    <option data-countryCode="SG" value="65" {{ "65" == $countryCode ? 'selected' : '' }}>Singapore (+65)</option>
                                                    <option data-countryCode="SK" value="421" {{ "421" == $countryCode ? 'selected' : '' }}>Slovak Republic (+421)</option>
                                                    <option data-countryCode="SI" value="386" {{ "386" == $countryCode ? 'selected' : '' }}>Slovenia (+386)</option>
                                                    <option data-countryCode="SB" value="677" {{ "677" == $countryCode ? 'selected' : '' }}>Solomon Islands (+677)</option>
                                                    <option data-countryCode="SO" value="252" {{ "252" == $countryCode ? 'selected' : '' }}>Somalia (+252)</option>
                                                    <option data-countryCode="ZA" value="27" {{ "27" == $countryCode ? 'selected' : '' }}>South Africa (+27)</option>
                                                    <option data-countryCode="ES" value="34" {{ "34" == $countryCode ? 'selected' : '' }}>Spain (+34)</option>
                                                    <option data-countryCode="LK" value="94" {{ "94" == $countryCode ? 'selected' : '' }}>Sri Lanka (+94)</option>
                                                    <option data-countryCode="SH" value="290" {{ "290" == $countryCode ? 'selected' : '' }}>St. Helena (+290)</option>
                                                    <option data-countryCode="KN" value="1869" {{ "1869" == $countryCode ? 'selected' : '' }}>St. Kitts (+1869)</option>
                                                    <option data-countryCode="SC" value="1758" {{ "1758" == $countryCode ? 'selected' : '' }}>St. Lucia (+1758)</option>
                                                    <option data-countryCode="SD" value="249" {{ "249" == $countryCode ? 'selected' : '' }}>Sudan (+249)</option>
                                                    <option data-countryCode="SR" value="597" {{ "597" == $countryCode ? 'selected' : '' }}>Suriname (+597)</option>
                                                    <option data-countryCode="SZ" value="268" {{ "268" == $countryCode ? 'selected' : '' }}>Swaziland (+268)</option>
                                                    <option data-countryCode="SE" value="46" {{ "46" == $countryCode ? 'selected' : '' }}>Sweden (+46)</option>
                                                    <option data-countryCode="CH" value="41">Switzerland (+41)</option>
                                                    <option data-countryCode="SI" value="963" {{ "963" == $countryCode ? 'selected' : '' }}>Syria (+963)</option>
                                                    <option data-countryCode="TW" value="886" {{ "886" == $countryCode ? 'selected' : '' }}>Taiwan (+886)</option>
                                                    <option data-countryCode="TJ" value="7" {{ "7" == $countryCode ? 'selected' : '' }}>Tajikstan (+7)</option>
                                                    <option data-countryCode="TH" value="66" {{ "66" == $countryCode ? 'selected' : '' }}>Thailand (+66)</option>
                                                    <option data-countryCode="TG" value="228" {{ "228" == $countryCode ? 'selected' : '' }}>Togo (+228)</option>
                                                    <option data-countryCode="TO" value="676" {{ "676" == $countryCode ? 'selected' : '' }}>Tonga (+676)</option>
                                                    <option data-countryCode="TT" value="1868" {{ "1868" == $countryCode ? 'selected' : '' }}>Trinidad &amp; Tobago (+1868)</option>
                                                    <option data-countryCode="TN" value="216" {{ "216" == $countryCode ? 'selected' : '' }}>Tunisia (+216)</option>
                                                    <option data-countryCode="TR" value="90" {{ "90" == $countryCode ? 'selected' : '' }}>Turkey (+90)</option>
                                                    <option data-countryCode="TM" value="7" {{ "7" == $countryCode ? 'selected' : '' }}>Turkmenistan (+7)</option>
                                                    <option data-countryCode="TM" value="993" {{ "993" == $countryCode ? 'selected' : '' }}>Turkmenistan (+993)</option>
                                                    <option data-countryCode="TC" value="1649" {{ "1649" == $countryCode ? 'selected' : '' }}>Turks &amp; Caicos Islands (+1649)</option>
                                                    <option data-countryCode="TV" value="688" {{ "688" == $countryCode ? 'selected' : '' }}>Tuvalu (+688)</option>
                                                    <option data-countryCode="UG" value="256" {{ "256" == $countryCode ? 'selected' : '' }}>Uganda (+256)</option>
                                                    <option data-countryCode="GB" value="44" {{ "44" == $countryCode ? 'selected' : '' }}>UK (+44)</option>
                                                    <option data-countryCode="UA" value="380" {{ "380" == $countryCode ? 'selected' : '' }}>Ukraine (+380)</option>
                                                    <option data-countryCode="AE" value="971" {{ "971" == $countryCode ? 'selected' : '' }}>United Arab Emirates (+971)</option>
                                                    <option data-countryCode="UY" value="598" {{ "598" == $countryCode ? 'selected' : '' }}>Uruguay (+598)</option>
                                                    <option data-countryCode="US" value="1" {{ "1" == $countryCode ? 'selected' : '' }}>USA (+1)</option>
                                                    <option data-countryCode="UZ" value="7" {{ "7" == $countryCode ? 'selected' : '' }}>Uzbekistan (+7)</option>
                                                    <option data-countryCode="VU" value="678" {{ "678" == $countryCode ? 'selected' : '' }}>Vanuatu (+678)</option>
                                                    <option data-countryCode="VA" value="379" {{ "379" == $countryCode ? 'selected' : '' }}>Vatican City (+379)</option>
                                                    <option data-countryCode="VE" value="58" {{ "58" == $countryCode ? 'selected' : '' }}>Venezuela (+58)</option>
                                                    <option data-countryCode="VN" value="84" {{ "84" == $countryCode ? 'selected' : '' }}>Vietnam (+84)</option>
                                                    <option data-countryCode="VG" value="84" {{ "84" == $countryCode ? 'selected' : '' }}>Virgin Islands - British (+1284)</option>
                                                    <option data-countryCode="VI" value="84" {{ "84" == $countryCode ? 'selected' : '' }}>Virgin Islands - US (+1340)</option>
                                                    <option data-countryCode="WF" value="681" {{ "681" == $countryCode ? 'selected' : '' }}>Wallis &amp; Futuna (+681)</option>
                                                    <option data-countryCode="YE" value="969" {{ "969" == $countryCode ? 'selected' : '' }}>Yemen (North)(+969)</option>
                                                    <option data-countryCode="YE" value="967" {{ "967" == $countryCode ? 'selected' : '' }}>Yemen (South)(+967)</option>
                                                    <option data-countryCode="ZM" value="260" {{ "260" == $countryCode ? 'selected' : '' }}>Zambia (+260)</option>
                                                    <option data-countryCode="ZW" value="263" {{ "263" == $countryCode ? 'selected' : '' }}>Zimbabwe (+263)</option>
                                                {{-- </optgroup> --}}
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="username">Phone</label>
                                            <input type="text" class="form-control"
                                                id="phone"placeholder="Enter phone" name="phone"
                                                value="{{ $phone }}" required>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="address_1">Address 1</label>
                                            <input type="text" class="form-control" id="address_1"
                                                placeholder="Enter address 1" name="address_1"
                                                value="{{ $user->address_1 }}" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="address_2">Address 2</label>
                                            <input type="text" class="form-control"
                                                id="address_2"placeholder="Enter address 2" name="address_2"
                                                value="{{ $user->address_2 }}" required>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="city">City</label>
                                            <input type="text" class="form-control" id="city"
                                                placeholder="Enter city" name="city" value="{{ $user->city }}"
                                                required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="state">State</label>
                                            <input type="text" class="form-control"
                                                id="state"placeholder="Enter state" name="state"
                                                value="{{ $user->state }}" required>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="zip">Zip COde</label>
                                            <input type="text" class="form-control" id="zip"
                                                placeholder="Enter zip " name="zip" value="{{ $user->zip }}"
                                                required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="country">Country</label>
                                            <select class="form-control" name="country" id="country">
                                                @foreach ($country as $countries)
                                                    <option value="{{ $countries->sortname }}"
                                                        {{ $countries->sortname == $user->country ? 'selected' : '' }}>
                                                        {{ $countries->countries }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="userimage">Upload Image</label>
                                            <input type="file" class="form-control" name="userimage" id="userimage">

                                            @if ($user->logo != '')
                                                <div class="form-group col-md-12">

                                                    <img src="{{ $user->logo }}"
                                                        style="height: 50px;">
                                                </div>
                                            @endif
                                        </div>

                                    </div>
                                    <!-- /.card-body -->

                                    <div class="card-footer">
                                        <div class="col-4">
                                            <input type="submit" class="btn btn-primary btn-block" value="Update">
                                        </div>
                                    </div>
                            </form>
                        </div>
                        <!-- /.card-primary -->
                    </div>
                    <!--/.col-md-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
