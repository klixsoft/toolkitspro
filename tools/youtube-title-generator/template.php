<style>
.yt_tags {
    background: #ebebeb;
    padding: 5px 10px;
    border-radius: 3px;
    margin-right: 10px;
    margin-bottom: 10px;
    display: inline-block;
    cursor: pointer;
}

.youtube-title-generator_report .card {
    border-radius: 0;
}

.youtube-title-generator_report .card-body {
    padding: 1rem;
    font-weight: bold;
}


.modal__actions-button {
    position: relative;
    display: flex;
    align-items: center;
    margin-left: auto;
    padding: 0 12px;
    background: #fff;
    border: 1px solid var(--primary);
    border-radius: 0;
    color: var(--primary);
    font-size: 11px;
    font-weight: bold;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    overflow: hidden;
    cursor: pointer;
    transition: all 250ms ease-out;
    padding: 5px 12px;
}

.modal__actions-button span {
    margin-left: 6px;
}

.modal__actions-button-copied {
    display: flex;
    align-items: center;
    justify-content: center;
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: var(--primary);
    border: 1px solid var(--primary);
    border-radius: 0;
    color: #fff;
    transform: translateY(105%);
    transition: all 250ms ease-out;
}

.yt-tags-formatter_copy.active .modal__actions-button-copied,
.yt-tags-formatter_download.active .modal__actions-button-copied {
    transform: translateY(0%);
}

.yt-tags-formatter_copy,
.yt-tags-formatter_download {
    color: var(--primary);
}

.yt-tags-formatter_copy i,
.yt-tags-formatter_download i {
    font-size: 18px;
}

.modal__actions {
    display: flex;
    align-items: center;
    background: #E0E8F3;
    padding: 12px 24px;
    justify-content: space-between;
}

.footer_button_row {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 5px;
}
</style>

<div class="youtube-title-generator_content">
    <form action="<?php echo get_full_url(); ?>" method="post" class="youtube-title-generator_submit_form">
        <div class="row">
            <div class="col-md-8">
                <div class="form-group mt-3">
                    <label>Keyword</label>
                    <input type="text" placeholder="Keywords" name="keyword" required class="form-control">
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group mt-3">
                    <label>Country</label>
                    <select class="form-control" name="country" required>
                        <option value="us">United States (us)</option>
                        <option value="af">Afghanistan (af)</option>
                        <option value="ax">Aland Islands (ax)</option>
                        <option value="al">Albania (al)</option>
                        <option value="dz">Algeria (dz)</option>
                        <option value="as">American Samoa (as)</option>
                        <option value="ad">Andorra (ad)</option>
                        <option value="ao">Angola (ao)</option>
                        <option value="ai">Anguilla (ai)</option>
                        <option value="aq">Antarctica (aq)</option>
                        <option value="ag">Antigua and Barbuda (ag)</option>
                        <option value="ar">Argentina (ar)</option>
                        <option value="am">Armenia (am)</option>
                        <option value="aw">Aruba (aw)</option>
                        <option value="au">Australia (au)</option>
                        <option value="at">Austria (at)</option>
                        <option value="az">Azerbaijan (az)</option>
                        <option value="bs">Bahamas (bs)</option>
                        <option value="bh">Bahrain (bh)</option>
                        <option value="bd">Bangladesh (bd)</option>
                        <option value="bb">Barbados (bb)</option>
                        <option value="by">Belarus (by)</option>
                        <option value="be">Belgium (be)</option>
                        <option value="bz">Belize (bz)</option>
                        <option value="bj">Benin (bj)</option>
                        <option value="bm">Bermuda (bm)</option>
                        <option value="bt">Bhutan (bt)</option>
                        <option value="bo">Bolivia, Plurinational State of (bo)</option>
                        <option value="bq">Bonaire, Sint Eustatius and Saba (bq)</option>
                        <option value="ba">Bosnia and Herzegovina (ba)</option>
                        <option value="bw">Botswana (bw)</option>
                        <option value="bv">Bouvet Island (bv)</option>
                        <option value="br">Brazil (br)</option>
                        <option value="io">British Indian Ocean Territory (io)</option>
                        <option value="bn">Brunei Darussalam (bn)</option>
                        <option value="bg">Bulgaria (bg)</option>
                        <option value="bf">Burkina Faso (bf)</option>
                        <option value="bi">Burundi (bi)</option>
                        <option value="kh">Cambodia (kh)</option>
                        <option value="cm">Cameroon (cm)</option>
                        <option value="ca">Canada (ca)</option>
                        <option value="cv">Cape Verde (cv)</option>
                        <option value="ky">Cayman Islands (ky)</option>
                        <option value="cf">Central African Republic (cf)</option>
                        <option value="td">Chad (td)</option>
                        <option value="cl">Chile (cl)</option>
                        <option value="cn">China (cn)</option>
                        <option value="cx">Christmas Island (cx)</option>
                        <option value="cc">Cocos (Keeling) Islands (cc)</option>
                        <option value="co">Colombia (co)</option>
                        <option value="km">Comoros (km)</option>
                        <option value="cg">Congo (cg)</option>
                        <option value="cd">Congo, the Democratic Republic of the (cd)</option>
                        <option value="ck">Cook Islands (ck)</option>
                        <option value="cr">Costa Rica (cr)</option>
                        <option value="ci">Côte d'Ivoire (ci)</option>
                        <option value="hr">Croatia (hr)</option>
                        <option value="cu">Cuba (cu)</option>
                        <option value="cw">Curaçao (cw)</option>
                        <option value="cy">Cyprus (cy)</option>
                        <option value="cz">Czech Republic (cz)</option>
                        <option value="dk">Denmark (dk)</option>
                        <option value="dj">Djibouti (dj)</option>
                        <option value="dm">Dominica (dm)</option>
                        <option value="do">Dominican Republic (do)</option>
                        <option value="ec">Ecuador (ec)</option>
                        <option value="eg">Egypt (eg)</option>
                        <option value="sv">El Salvador (sv)</option>
                        <option value="gq">Equatorial Guinea (gq)</option>
                        <option value="er">Eritrea (er)</option>
                        <option value="ee">Estonia (ee)</option>
                        <option value="et">Ethiopia (et)</option>
                        <option value="fk">Falkland Islands (Malvinas) (fk)</option>
                        <option value="fo">Faroe Islands (fo)</option>
                        <option value="fj">Fiji (fj)</option>
                        <option value="fi">Finland (fi)</option>
                        <option value="fr">France (fr)</option>
                        <option value="gf">French Guiana (gf)</option>
                        <option value="pf">French Polynesia (pf)</option>
                        <option value="tf">French Southern Territories (tf)</option>
                        <option value="ga">Gabon (ga)</option>
                        <option value="gm">Gambia (gm)</option>
                        <option value="ge">Georgia (ge)</option>
                        <option value="de">Germany (de)</option>
                        <option value="gh">Ghana (gh)</option>
                        <option value="gi">Gibraltar (gi)</option>
                        <option value="gr">Greece (gr)</option>
                        <option value="gl">Greenland (gl)</option>
                        <option value="gd">Grenada (gd)</option>
                        <option value="gp">Guadeloupe (gp)</option>
                        <option value="gu">Guam (gu)</option>
                        <option value="gt">Guatemala (gt)</option>
                        <option value="gg">Guernsey (gg)</option>
                        <option value="gn">Guinea (gn)</option>
                        <option value="gw">Guinea-Bissau (gw)</option>
                        <option value="gy">Guyana (gy)</option>
                        <option value="ht">Haiti (ht)</option>
                        <option value="hm">Heard Island and McDonald Islands (hm)</option>
                        <option value="va">Holy See (Vatican City State) (va)</option>
                        <option value="hn">Honduras (hn)</option>
                        <option value="hk">Hong Kong (hk)</option>
                        <option value="hu">Hungary (hu)</option>
                        <option value="is">Iceland (is)</option>
                        <option value="in">India (in)</option>
                        <option value="id">Indonesia (id)</option>
                        <option value="ir">Iran, Islamic Republic of (ir)</option>
                        <option value="iq">Iraq (iq)</option>
                        <option value="ie">Ireland (ie)</option>
                        <option value="im">Isle of Man (im)</option>
                        <option value="il">Israel (il)</option>
                        <option value="it">Italy (it)</option>
                        <option value="jm">Jamaica (jm)</option>
                        <option value="jp">Japan (jp)</option>
                        <option value="je">Jersey (je)</option>
                        <option value="jo">Jordan (jo)</option>
                        <option value="kz">Kazakhstan (kz)</option>
                        <option value="ke">Kenya (ke)</option>
                        <option value="ki">Kiribati (ki)</option>
                        <option value="kp">Korea, Democratic People's Republic of (kp)</option>
                        <option value="kr">Korea, Republic of (kr)</option>
                        <option value="kw">Kuwait (kw)</option>
                        <option value="kg">Kyrgyzstan (kg)</option>
                        <option value="la">Lao People's Democratic Republic (la)</option>
                        <option value="lv">Latvia (lv)</option>
                        <option value="lb">Lebanon (lb)</option>
                        <option value="ls">Lesotho (ls)</option>
                        <option value="lr">Liberia (lr)</option>
                        <option value="ly">Libya (ly)</option>
                        <option value="li">Liechtenstein (li)</option>
                        <option value="lt">Lithuania (lt)</option>
                        <option value="lu">Luxembourg (lu)</option>
                        <option value="mo">Macao (mo)</option>
                        <option value="mk">Macedonia, the former Yugoslav Republic of (mk)</option>
                        <option value="mg">Madagascar (mg)</option>
                        <option value="mw">Malawi (mw)</option>
                        <option value="my">Malaysia (my)</option>
                        <option value="mv">Maldives (mv)</option>
                        <option value="ml">Mali (ml)</option>
                        <option value="mt">Malta (mt)</option>
                        <option value="mh">Marshall Islands (mh)</option>
                        <option value="mq">Martinique (mq)</option>
                        <option value="mr">Mauritania (mr)</option>
                        <option value="mu">Mauritius (mu)</option>
                        <option value="yt">Mayotte (yt)</option>
                        <option value="mx">Mexico (mx)</option>
                        <option value="fm">Micronesia, Federated States of (fm)</option>
                        <option value="md">Moldova, Republic of (md)</option>
                        <option value="mc">Monaco (mc)</option>
                        <option value="mn">Mongolia (mn)</option>
                        <option value="me">Montenegro (me)</option>
                        <option value="ms">Montserrat (ms)</option>
                        <option value="ma">Morocco (ma)</option>
                        <option value="mz">Mozambique (mz)</option>
                        <option value="mm">Myanmar (mm)</option>
                        <option value="na">Namibia (na)</option>
                        <option value="nr">Nauru (nr)</option>
                        <option value="np">Nepal (np)</option>
                        <option value="nl">Netherlands (nl)</option>
                        <option value="nc">New Caledonia (nc)</option>
                        <option value="nz">New Zealand (nz)</option>
                        <option value="ni">Nicaragua (ni)</option>
                        <option value="ne">Niger (ne)</option>
                        <option value="ng">Nigeria (ng)</option>
                        <option value="nu">Niue (nu)</option>
                        <option value="nf">Norfolk Island (nf)</option>
                        <option value="mp">Northern Mariana Islands (mp)</option>
                        <option value="no">Norway (no)</option>
                        <option value="om">Oman (om)</option>
                        <option value="pk">Pakistan (pk)</option>
                        <option value="pw">Palau (pw)</option>
                        <option value="ps">Palestinian Territory, Occupied (ps)</option>
                        <option value="pa">Panama (pa)</option>
                        <option value="pg">Papua New Guinea (pg)</option>
                        <option value="py">Paraguay (py)</option>
                        <option value="pe">Peru (pe)</option>
                        <option value="ph">Philippines (ph)</option>
                        <option value="pn">Pitcairn (pn)</option>
                        <option value="pl">Poland (pl)</option>
                        <option value="pt">Portugal (pt)</option>
                        <option value="pr">Puerto Rico (pr)</option>
                        <option value="qa">Qatar (qa)</option>
                        <option value="re">Réunion (re)</option>
                        <option value="ro">Romania (ro)</option>
                        <option value="ru">Russian Federation (ru)</option>
                        <option value="rw">Rwanda (rw)</option>
                        <option value="bl">Saint Barthélemy (bl)</option>
                        <option value="sh">Saint Helena, Ascension and Tristan da Cunha (sh)</option>
                        <option value="kn">Saint Kitts and Nevis (kn)</option>
                        <option value="lc">Saint Lucia (lc)</option>
                        <option value="mf">Saint Martin (French part) (mf)</option>
                        <option value="pm">Saint Pierre and Miquelon (pm)</option>
                        <option value="vc">Saint Vincent and the Grenadines (vc)</option>
                        <option value="ws">Samoa (ws)</option>
                        <option value="sm">San Marino (sm)</option>
                        <option value="st">Sao Tome and Principe (st)</option>
                        <option value="sa">Saudi Arabia (sa)</option>
                        <option value="sn">Senegal (sn)</option>
                        <option value="rs">Serbia (rs)</option>
                        <option value="sc">Seychelles (sc)</option>
                        <option value="sl">Sierra Leone (sl)</option>
                        <option value="sg">Singapore (sg)</option>
                        <option value="sx">Sint Maarten (Dutch part) (sx)</option>
                        <option value="sk">Slovakia (sk)</option>
                        <option value="si">Slovenia (si)</option>
                        <option value="sb">Solomon Islands (sb)</option>
                        <option value="so">Somalia (so)</option>
                        <option value="za">South Africa (za)</option>
                        <option value="gs">South Georgia and the South Sandwich Islands (gs)</option>
                        <option value="ss">South Sudan (ss)</option>
                        <option value="es">Spain (es)</option>
                        <option value="lk">Sri Lanka (lk)</option>
                        <option value="sd">Sudan (sd)</option>
                        <option value="sr">Suriname (sr)</option>
                        <option value="sj">Svalbard and Jan Mayen (sj)</option>
                        <option value="sz">Swaziland (sz)</option>
                        <option value="se">Sweden (se)</option>
                        <option value="ch">Switzerland (ch)</option>
                        <option value="sy">Syrian Arab Republic (sy)</option>
                        <option value="tw">Taiwan, Province of China (tw)</option>
                        <option value="tj">Tajikistan (tj)</option>
                        <option value="tz">Tanzania, United Republic of (tz)</option>
                        <option value="th">Thailand (th)</option>
                        <option value="tl">Timor-Leste (tl)</option>
                        <option value="tg">Togo (tg)</option>
                        <option value="tk">Tokelau (tk)</option>
                        <option value="to">Tonga (to)</option>
                        <option value="tt">Trinidad and Tobago (tt)</option>
                        <option value="tn">Tunisia (tn)</option>
                        <option value="tr">Turkey (tr)</option>
                        <option value="tm">Turkmenistan (tm)</option>
                        <option value="tc">Turks and Caicos Islands (tc)</option>
                        <option value="tv">Tuvalu (tv)</option>
                        <option value="ug">Uganda (ug)</option>
                        <option value="ua">Ukraine (ua)</option>
                        <option value="ae">United Arab Emirates (ae)</option>
                        <option value="gb">United Kingdom (gb)</option>
                        <option value="um">United States Minor Outlying Islands (um)</option>
                        <option value="uy">Uruguay (uy)</option>
                        <option value="uz">Uzbekistan (uz)</option>
                        <option value="vu">Vanuatu (vu)</option>
                        <option value="ve">Venezuela, Bolivarian Republic of (ve)</option>
                        <option value="vn">Viet Nam (vn)</option>
                        <option value="vg">Virgin Islands, British (vg)</option>
                        <option value="vi">Virgin Islands, U.S. (vi)</option>
                        <option value="wf">Wallis and Futuna (wf)</option>
                        <option value="eh">Western Sahara (eh)</option>
                        <option value="ye">Yemen (ye)</option>
                        <option value="zm">Zambia (zm)</option>
                        <option value="zw">Zimbabwe (zw)</option>
                    </select>
                </div>
            </div>
        </div>

        <?php
            /**
             * Render Captcha Settings
             */
            do_action("ast/captcha/render", $tool, $report); 
        ?>

        <div class="button-group text-center my-4">
            <input type="text" value="youtube-title-generator" name="tool" class="d-none">
            <input type="text" value="<?php echo $tool->id; ?>" name="toolid" class="d-none">
            <input type="text" value="process_youtube_title_generator_checker" name="action" class="d-none">
            <button type="submit" class="btn btn-primary text-white">Generate Youtube Title</button>
        </div>

        <div class="form-group d-none">
            <label>Search Result</label>

            <div class="youtube-title-generator_report_container mt-3">
                <div class="youtube-title-generator_report">



                </div>
            </div>
        </div>
    </form>
</div>