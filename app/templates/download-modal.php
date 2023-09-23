<style>
.modal-confirm .modal-content {
    padding: 20px;
    border-radius: 5px;
    border: none;
}

.modal-confirm .modal-header {
    border-bottom: none;
    position: relative;
}

.modal-confirm h4 {
    text-align: center;
    font-size: 26px;
    margin: 30px 0 -15px;
}

.modal-confirm .modal-footer {
    border: none;
    text-align: center;
    border-radius: 5px;
    font-size: 13px;
}

.modal-confirm .icon-box {
    color: #fff;
    position: absolute;
    margin: 0 auto;
    left: 0;
    right: 0;
    top: -70px;
    width: 95px;
    height: 95px;
    border-radius: 50%;
    z-index: 9;
    background: var(--primary);
    padding: 15px;
    text-align: center;
    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);
}

.modal-confirm .icon-box i {
    font-size: 58px;
    position: relative;
    top: 3px;
}

.modal-confirm.modal-dialog {
    margin-top: 80px;
}

.modal-confirm .btn {
    color: #fff;
    border-radius: 4px;
    background: var(--primary);
    text-decoration: none;
    transition: all 0.4s;
    line-height: normal;
    border: none;
    padding: 15px 0;
    font-size: 1rem;
}
</style>

<!-- Modal HTML -->
<div id="downloadedModal" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content">
            <div class="modal-header">
                <div class="icon-box">
                    <i class="las la-check"></i>
                </div>
                <h4 class="modal-title w-100">Success!</h4>
            </div>
            <div class="modal-body">
                <p class="text-center mb-0">PDF processed successfully. Please click on the <strong>Download PDF</strong> button to download.</p>
            </div>
            <div class="modal-footer">
                <a href="" target="_blank" class="downloadPDFLink btn btn-success btn-block w-100" data-dismiss="modal">Download PDF</button>
                <a href="" class="reloadPDFLink btn btn-warning bg-warning text-white w-100">Close and Reload</a>
            </div>
        </div>
    </div>
</div>