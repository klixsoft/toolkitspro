<style>
.card {
    border: none;
}

.search {
    width: 100%;
    margin-bottom: auto;
    margin-top: 20px;
    height: 50px;
    background-color: #f2f2f2;
    padding: 10px;
    border-radius: 5px;
}

.search-input {
    color: white;
    border: 0;
    outline: 0;
    background: none;
    width: 0;
    margin-top: 5px;
    caret-color: transparent;
    line-height: 20px;
    transition: width 0.4s linear
}

.search .search-input {
    padding: 0 10px;
    width: 100%;
    caret-color: var(--primary);
    font-size: 19px;
    font-weight: 300;
    color: black;
    transition: width 0.4s linear;
}
</style>

<div class="container mt-4 mb-4 pb-2 tools_section main_search_page">
    <div class="row d-flex justify-content-center">
        <div class="col-md-9">
            <div class="card p-4 mt-3 card-box">
                <h3 class="heading mt-5 text-center">Search Any Tools?</h3>
                <div class="d-flex justify-content-center px-4">
                    <div class="search"> <input type="text" class="search-input searchtools" placeholder="Search..." value="<?php echo isset($_GET['s']) ? $_GET['s'] : ""; ?>"> </div>
                </div>
                <div class="row mt-4 g-1 px-4 mb-5 toolslist">
                    <div style="display:none;" class="tkp_spinner tkp_spinner justify-content-center mt-3 mb-4 w-100">
                        <div class="spinner"></div>
                    </div>
                    <div class="tools w-100"></div>
                </div>
            </div>
        </div>
    </div>
</div>