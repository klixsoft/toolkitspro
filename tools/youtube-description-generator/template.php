<style>
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

.yt-desc-generator_copy.active .modal__actions-button-copied,
.yt-desc-generator_download.active .modal__actions-button-copied {
    transform: translateY(0%);
}

.yt-desc-generator_copy,
.yt-desc-generator_download {
    color: var(--primary);
}

.yt-desc-generator_copy i,
.yt-desc-generator_download i {
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

.modal__actions{
    position: sticky;
    bottom:0;
}
</style>

<div class="youtube-description-generator_content">
    <div class="form-group">
        <label>About the Video</label>
        <em class="mb-2 d-block">A Detailed explanation of what the video is about, including important keywords.</em>
        <textarea name="aboutvideo" rows="5" class="form-control inputchange">Hi, thanks for watching our video about {your video}!
In this video, we'll walk you through:
- {Topic 1}
- {Topic 2}
- {Topic 3}</textarea>
    </div>


    <div class="form-group mt-4">
        <label>Timestamps</label>
        <em class="mb-2 d-block">A breakdown of the main sections of your video by time. Similar to a Table of Contents
            Ideally these should actually be links to the specific time section of the video as well.</em>
        <textarea name="timestamps" rows="5" class="form-control inputchange">TIMESTAMPS
0:00 Intro
1:00 First Topic Covered
1:30 Second Topic Covered
2:30 Third Topic Covered</textarea>
    </div>


    <div class="form-group mt-4">
        <label>About the Channel</label>
        <em class="mb-2 d-block">Briefly explain the type of content you publish on your channel.</em>
        <textarea name="aboutchanel" rows="5" class="form-control inputchange">ABOUT OUR CHANNEL
Our channel is about {topic}. We cover lots of cool stuff such as {topic}, {topic} and {topic}
Check out our channel here:
https://www.youtube.com/channel
Don't forget to subscribe!</textarea>
    </div>


    <div class="form-group mt-4">
        <label>Other Recommended Videos / Playlists</label>
        <textarea name="recommended" rows="4" class="form-control inputchange">CHECK OUT OUR OTHER VIDEOS
https://www.youtube.com/watch?v=video1
https://www.youtube.com/watch?v=video2
https://www.youtube.com/watch?v=video3</textarea>
    </div>

    <div class="form-group mt-4">
        <label>About Our Products & Company</label>
        <textarea name="ourproducts" rows="4" class="form-control inputchange">We sell these excellent products. Check them out here:
https://www.website.com/product1
https://www.website.com/product2
https://www.website.com/product3</textarea>
    </div>

    <div class="form-group mt-4">
        <label>Our Website</label>
        <textarea name="websites" rows="3" class="form-control inputchange">FIND US AT
https://www.website.com/</textarea>
    </div>

    <div class="form-group mt-4">
        <label>Contact & Social</label>
        <textarea name="contact" rows="6" class="form-control inputchange">GET IN TOUCH
Contact us at info@company.com

FOLLOW US ON SOCIAL
Get updates or reach out to Get updates on our Social Media Profiles!
Twitter: https://twitter.com/{profile}
Facebook: https://facebook.com/{profile}
Instagram: https://twitter.com/{profile}
Spotify: http://spotify.com/{profile}</textarea>
    </div>


    <div class="form-group mt-5">
        <label>Your Youtube Description:</label>

        <textarea id="yt_description_result" disabled rows="15" class="form-control scrollbar"></textarea>
        <div class="modal__actions">
            <div class="modal__actions-helper">
                Youtube Description <code>description.txt</code>
            </div>
            <div class="footer_button_row">
                <button type="button" class="modal__actions-button yt-desc-generator_copy">
                    <i class="las la-code"></i>
                    <span>Copy</span>
                    <div class="modal__actions-button-copied js-copied">Copied!</div>
                </button>

                <button type="button" class="modal__actions-button yt-desc-generator_download">
                    <i class="las la-download"></i>
                    <span>Download</span>
                    <div class="modal__actions-button-copied js-copied">Downloaded!</div>
                </button>
            </div>
        </div>
    </div>
</div>