<style>
#loadingModal .spinner,
.tkp_spinner .spinner {
    width: 72px;
    height: 72px;
    display: grid;
    border: 5.8px solid #0000;
    border-radius: 50%;
    border-color: #dbdcef #0000;
    animation: spinner-e04l1k 1s infinite linear;
}

#loadingModal .spinner::before,
#loadingModal .spinner::after,
.tkp_spinner .spinner::before,
.tkp_spinner .spinner::after {
    content: "";
    grid-area: 1/1;
    margin: 2.9px;
    border: inherit;
    border-radius: 50%;
}

#loadingModal .spinner::before,
.tkp_spinner .spinner::before {
    border-color: var(--primary) #0000;
    animation: inherit;
    animation-duration: 0.5s;
    animation-direction: reverse;
}

#loadingModal .spinner::after,
.tkp_spinner .spinner::after {
    margin: 11.6px;
}

@keyframes spinner-e04l1k {
    100% {
        transform: rotate(1turn);
    }
}

#loadingModal .modal-body{
    display: flex;
    justify-content: center;
    flex-direction: column;
    align-items: center;
}

#loadingModal .modal-body .message{
    margin-top:10px;
}
</style>

<div class="modal fade" id="loadingModal">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="spinner"></div>
                <div class="message">Please Wait . . .</div>
            </div>
        </div>
    </div>
</div>