$(document).ready(function () {
    function update_adsense_earning() {
        let impressions = parseInt($(document).find("input[name=pageimpression]").val());
        let ctr = parseFloat($(document).find("input[name=ctr]").val());
        let cpc = parseFloat($(document).find("input[name=cpc]").val());
        if (!isNaN(impressions) && !isNaN(ctr) && !isNaN(cpc)) {
            if (ctr > 100) ctr = 100;
            ctr = ctr / 100;
            const dailyEarningsValue = (impressions * ctr * cpc).toFixed(2);
            const monthlyEarningsValue = (dailyEarningsValue * 30).toFixed(2);
            const yearlyEarningsValue = (dailyEarningsValue * 365).toFixed(2);
            const dailyClicksValue = (impressions * ctr).toFixed(2);
            const monthlyClicksValue = (dailyClicksValue * 30).toFixed(2);
            const yearlyClicksValue = (dailyClicksValue * 365).toFixed(2);
            $(document).find(".dailyearning").text(dailyEarningsValue);
            $(document).find(".monthlyearning").text(monthlyEarningsValue);
            $(document).find(".yearlyearning").text(yearlyEarningsValue);
            $(document).find(".dailyclicks").text(dailyClicksValue);
            $(document).find(".monthlyclicks").text(monthlyClicksValue);
            $(document).find(".yearlyclicks").text(yearlyClicksValue)
        }
    }

    $(document).on("change keyup paste", ".adsense_calculator_submit_form input", function () {
        update_adsense_earning()
    });
});