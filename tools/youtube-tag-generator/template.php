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

.youtube-tag-generator_report .card {
    border-radius: 0;
}

.youtube-tag-generator_report .card-body {
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

<div class="youtube-tag-generator_content">
    <form action="<?php echo get_full_url(); ?>" method="post" class="youtube-tag-generator_submit_form">
        <div class="row">
            <div class="col-md-8">
                <div class="form-group mt-3">
                    <label>Keyword</label>
                    <input type="text" placeholder="keyword" name="keyword" required class="form-control">
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group mt-3">
                    <label>Language</label>
                    <select class="form-control" name="lang" required>
                        <option value="AF">Afrikaans</option>
                        <option value="SQ">Albanian</option>
                        <option value="AR">Arabic</option>
                        <option value="HY">Armenian</option>
                        <option value="EU">Basque</option>
                        <option value="BN">Bengali</option>
                        <option value="BG">Bulgarian</option>
                        <option value="CA">Catalan</option>
                        <option value="KM">Cambodian</option>
                        <option value="ZH">Chinese (Mandarin)</option>
                        <option value="HR">Croatian</option>
                        <option value="CS">Czech</option>
                        <option value="DA">Danish</option>
                        <option value="NL">Dutch</option>
                        <option value="EN" selected>English</option>
                        <option value="ET">Estonian</option>
                        <option value="FJ">Fiji</option>
                        <option value="FI">Finnish</option>
                        <option value="FR">French</option>
                        <option value="KA">Georgian</option>
                        <option value="DE">German</option>
                        <option value="EL">Greek</option>
                        <option value="GU">Gujarati</option>
                        <option value="HE">Hebrew</option>
                        <option value="HI">Hindi</option>
                        <option value="HU">Hungarian</option>
                        <option value="IS">Icelandic</option>
                        <option value="ID">Indonesian</option>
                        <option value="GA">Irish</option>
                        <option value="IT">Italian</option>
                        <option value="JA">Japanese</option>
                        <option value="JW">Javanese</option>
                        <option value="KO">Korean</option>
                        <option value="LA">Latin</option>
                        <option value="LV">Latvian</option>
                        <option value="LT">Lithuanian</option>
                        <option value="MK">Macedonian</option>
                        <option value="MS">Malay</option>
                        <option value="ML">Malayalam</option>
                        <option value="MT">Maltese</option>
                        <option value="MI">Maori</option>
                        <option value="MR">Marathi</option>
                        <option value="MN">Mongolian</option>
                        <option value="NE">Nepali</option>
                        <option value="NO">Norwegian</option>
                        <option value="FA">Persian</option>
                        <option value="PL">Polish</option>
                        <option value="PT">Portuguese</option>
                        <option value="PA">Punjabi</option>
                        <option value="QU">Quechua</option>
                        <option value="RO">Romanian</option>
                        <option value="RU">Russian</option>
                        <option value="SM">Samoan</option>
                        <option value="SR">Serbian</option>
                        <option value="SK">Slovak</option>
                        <option value="SL">Slovenian</option>
                        <option value="ES">Spanish</option>
                        <option value="SW">Swahili</option>
                        <option value="SV">Swedish </option>
                        <option value="TA">Tamil</option>
                        <option value="TT">Tatar</option>
                        <option value="TE">Telugu</option>
                        <option value="TH">Thai</option>
                        <option value="BO">Tibetan</option>
                        <option value="TO">Tonga</option>
                        <option value="TR">Turkish</option>
                        <option value="UK">Ukrainian</option>
                        <option value="UR">Urdu</option>
                        <option value="UZ">Uzbek</option>
                        <option value="VI">Vietnamese</option>
                        <option value="CY">Welsh</option>
                        <option value="XH">Xhosa</option>
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
            <input type="text" value="youtube-tag-generator" name="tool" class="d-none">
            <input type="text" value="process_youtube_tag_generator_checker" name="action" class="d-none">
            <button type="submit" class="btn btn-primary text-white">Generate Youtube Tags</button>
        </div>

        <div class="form-group d-none">
            <label>Search Result</label>

            <div class="youtube-tag-generator_report_container mt-3">
                <div class="youtube-tag-generator_report">



                </div>
            </div>
        </div>
    </form>
</div>