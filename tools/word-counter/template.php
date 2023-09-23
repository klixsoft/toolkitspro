<style>
.word-counter_submit_form{
    background: rgba(0, 0, 0, 0.05);
    padding: 1rem;
    border-radius: 6px;
}

.card-value {
    font-size: 28px;
    display: block;
    text-align: center;
    line-height: 50px;
    padding-top: 5px;
    font-weight: 700;
    color: var(--primary);
}

.card-name {
    display: block;
    text-align: center;
    text-transform: capitalize;
    padding-bottom: 15px;
    font-weight: 600;
    font-size: 18px;
}

#read_time span {
    font-size: small;
}
</style>

<div class="word-counter_content">
    <div class="word-counter_submit_form">
        <div class="row wordBox">
            <div class="col-xs-6 col-md-3">
                <div class="bg-white">
                    <span class="card-value" id="num_word">0</span>
                    <span class="card-name">Words</span>
                </div>
            </div>
            <div class="col-xs-6 col-md-3">
                <div class="bg-white">
                    <span class="card-value" id="num_character">0</span>
                    <span class="card-name">Characters</span>
                </div>
            </div>
            <div class="col-xs-6 col-md-3">
                <div class="bg-white">
                    <span class="card-value" id="num_sentence">0</span>
                    <span class="card-name">Sentence</span>
                </div>
            </div>
            <div class="col-xs-6 col-md-3">
                <div class="bg-white">
                    <span class="card-value" id="read_time">0 <span>sec</span></span>
                    <span class="card-name">Read Time</span>
                </div>
            </div>
        </div>
        <div class="form-group mt-3">
            <div class="word-counter_input_container">
                <textarea rows="10" class="form-control" id="inputText" type="text"
                    placeholder="Type Something..."></textarea>
            </div>
        </div>
    </div>
</div>