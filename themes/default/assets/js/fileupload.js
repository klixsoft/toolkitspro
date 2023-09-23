/** GOOGLE DRIVE PICKER */
const googlePick = $(document).find("#googlePick");
if (googlePick.length > 0) {
    googlePick.attr("disabled", true);
    let tokenClient;
    let accessToken = null;
    let pickerInited = false;
    let gisInited = false;
    const SCOPES = 'https://www.googleapis.com/auth/drive.metadata.readonly';
    const CLIENT_ID = '737790137258-konbsmtfu4r0f55a0ng1pb2mff1lm9af.apps.googleusercontent.com';
    const API_KEY = 'AIzaSyCz9KB8xRd_dnh_ZJmOarz5wP1d_Qm6Eos';
    const APP_ID = '737790137258';

    window.onDriveApiLoad = function () {
        gapi.load('client:picker', onPickerDriveApiLoad);
    };

    async function onPickerDriveApiLoad() {
        await gapi.client.load('https://www.googleapis.com/discovery/v1/apis/drive/v3/rest');
        pickerInited = true;
        googlePick.attr("disabled", false);
    };

    window.driveIsLoaded = function () {
        tokenClient = google.accounts.oauth2.initTokenClient({
            client_id: CLIENT_ID,
            scope: SCOPES,
            callback : ''
        });
        gisInited = true;
    };

    function createPicker() {
        const view = new google.picker.View(google.picker.ViewId.DOCS);
        view.setMimeTypes('text/plain');
        const picker = new google.picker.PickerBuilder()
            .enableFeature(google.picker.Feature.NAV_HIDDEN)
            .enableFeature(google.picker.Feature.MULTISELECT_ENABLED)
            .setDeveloperKey(API_KEY)
            .setAppId(APP_ID)
            .setOAuthToken(accessToken)
            .addView(view)
            .addView(new google.picker.DocsUploadView())
            .setCallback(pickerCallback)
            .build();
        picker.setVisible(true);
    }

    async function pickerCallback(data) {
        if (data.action === google.picker.Action.PICKED) {
            const document = data[google.picker.Response.DOCUMENTS][0];
            const fileId = document[google.picker.Document.ID];
            const res = await gapi.client.drive.files.get({
                'fileId': fileId,
                'fields': '*',
            });

            if( typeof afterDrivePicked == 'function' ){
                afterDrivePicked(res.result);
            }
        }
    }

    googlePick.click(function () {
        tokenClient.callback = (response) => {
            if (response.error !== undefined) {
                throw (response);
            }
            accessToken = response.access_token;
            createPicker();
        };

        if (accessToken === null) {
            tokenClient.requestAccessToken({ prompt: 'consent' });
        } else {
            tokenClient.requestAccessToken({ prompt: '' });
        }
    });
}
/** GOOGLE DRIVE PICKER END */