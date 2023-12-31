$(document).ready(function () {
    const numberChars = "0123456789";
    const upperChars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    const lowerChars = "abcdefghiklmnopqrstuvwxyz";
    const specialChars = "$@$!%*#?&";

    String.prototype.replaceAt = function(index, replacement) {
        return this.substring(0, index) + replacement + this.substring(index + replacement.length);
    }

    function getAllCharacters(){
        let alphabetscharacters = generateAlphabetChar();
        const numbers = $(document).find("input[name=numbers]");
        const specialcharacter = $(document).find("input[name=specialcharacter]");
        if( numbers.is(":checked") ){
            alphabetscharacters += numberChars;
        }

        if( specialcharacter.is(":checked") ){
            alphabetscharacters += specialChars;
        }

        return alphabetscharacters;
    }

    function checkSequenceChar( password ){
        if( password.length > 0 ){
            const allcharacters = getAllCharacters();

            for(let i = 0; i < password.length - 1; i++){
                var n1 = password.charCodeAt( i );
				var n2 = password.charCodeAt( i+1 );

                if( ( n2 - n1 == 1 ) && ( ( n1 >= 48 && n1 <= 56 ) || ( n1 >= 65 && n1 <= 89 ) || ( n1 >= 97 && n1 <= 121 ) ) ){
                    let randomChar = allcharacters.charAt(Math.floor(Math.random() * allcharacters.length));
                    password = password.replaceAt(i+1, randomChar);
                }
            }
        }
        return password;
    }

    function generateAlphabetChar(){
        const uppercase = $(document).find("input[name=uppercase]");
        const lowercase = $(document).find("input[name=lowercase]");

        if( uppercase.is(":checked") && lowercase.is(":checked") ){
            return upperChars + lowerChars;
        }else if( uppercase.is(":checked") ){
            return upperChars;
        }else if( lowercase.is(":checked") ){
            return lowerChars;
        }
        return "";
    }

    function shuffleArray(array){
        for (var i = array.length - 1; i > 0; i--) {
            var j = Math.floor(Math.random() * (i + 1));
            var temp = array[i];
            array[i] = array[j];
            array[j] = temp;
        }
        return array;
    }

    function generatePassword() {
        const passwordLength = parseInt($(document).find("select[name=passwordlength]").find(":selected").val());
        var count = 0;
        var allChars = "";
        var randPasswordArray = Array(passwordLength);
        if ($(document).find("input[name=uppercase]").is(":checked")) {
            allChars = allChars + upperChars;
            count++;
            randPasswordArray.push(upperChars);
        }
        if ($(document).find("input[name=lowercase]").is(":checked")) {
            allChars = allChars + lowerChars;
            count++;
            randPasswordArray.push(lowerChars);
        }
        if ($(document).find("input[name=numbers]").is(":checked")) {
            allChars = allChars + numberChars;
            count++;
            randPasswordArray.push(numberChars);
        }
        if ($(document).find("input[name=specialcharacter]").is(":checked")) {
            allChars = allChars + specialChars;
            count++;
            randPasswordArray.push(specialChars);
        }

        if (count == 0 || passwordLength < 3) {
            alert('Invalid password length.');
            return;
        }
        
        randPasswordArray = randPasswordArray.fill(allChars, count);
        let password = shuffleArray(randPasswordArray.map(function (x) {
            return x[Math.floor(Math.random() * x.length)]
        })).join('');

        if( $(document).find("input[name=nosequencechar]").is(":checked") ){
            password = checkSequenceChar(password);
        }

        if( $(document).find("input[name=beginalphabet]").is(":checked") ){
            const n3 = password.charCodeAt(0);
            if( !( n3 >= 65 && n3 <= 90 ) && !( n3 >= 97 && n3 <= 122 ) ){
                const charactersonly = generateAlphabetChar();
                if( charactersonly.length > 0 ){
                    const randomChar = charactersonly.charAt(Math.floor(Math.random() * charactersonly.length));
                    password = password.replaceAt(0, randomChar);
                }
            }
        }

        $(document).find("input[name=password]").val(password);
    }

    $(document).on("change", ".passwordlength, .ast-switch-input", function(){
        generatePassword();
    })

    $(document).on("click", ".generatePassword", function(){
        generatePassword();
    });

    generatePassword();

    $(document).on("change", "input[name=uppercase], input[name=lowercase]", function(){
        const startWithChar = $(document).find("input[name=beginalphabet]");
        const lowercaseChar = $(document).find("input[name=lowercase]");
        const uppercaseChar = $(document).find("input[name=uppercase]");
        if( lowercaseChar.is(":checked") || uppercaseChar.is(":checked") ){
            startWithChar.attr("disabled", false);
        }else{
            startWithChar.prop("checked", false);
            startWithChar.attr("disabled", true);
        }
    });

    $(document).on("click", ".copyPassword", function (e) {
        e.preventDefault();
        const val = $(document).find("input[name=password]").val();
        if (val && val.length > 0) {
            copy_text(val);

            const toolTipid = $(this).attr("aria-describedby");
            const toolTipEle = $(document).find('#' + toolTipid);
            if( toolTipEle.length > 0 ){
                const toolTipContentEle = toolTipEle.find(".tooltip-inner");
                if( toolTipContentEle.length > 0 ){
                    toolTipContentEle.html("Copied");
                    setTimeout(() => {
                        toolTipContentEle.html("Click to Copy");
                    }, 2000);
                }
            }
        }
    });
});

