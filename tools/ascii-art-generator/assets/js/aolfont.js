"use strict";

var AolFont = AolFont || (function() {

    // ---------------------------------------------------------------------
    // private static variables
    
    // ---------------------------------------------------------------------
    // private static methods

    function generateTextLine(txt, bigChars, opts) {
        var charIndex, bigChar, overlap = 0, ii, row, outputFigText = [], len=txt.length;
        for (row = 0; row < opts.height; row++) {
            outputFigText[row] = "";
        }
        for (charIndex = 0; charIndex < len; charIndex++) {
            bigChar = bigChars[txt.substr(charIndex,1).charCodeAt(0)];
            if (bigChar) {
                for (ii = 0; ii < opts.height; ii++) {
                    outputFigText[ii] = outputFigText[ii] + bigChar[ii];
                }
            }
        }
        return outputFigText.join("\n");
    }
    
    // ---------------------------------------------------------------------
    // object definition
    
    return function() {
        var me = this,
            opts = null,
            comment = "",
            bigChars = {},
            isFontLoaded = false,
            forceHFullWidth = false;
    
        // ---------------------------------------------------------------------
        // public methods
    
        me.isReady = function() {
            return isFontLoaded;  
        };
    
        me.forceHorizontalFullWidthLayout = function(val) {};
        me.forceVerticalFullWidthLayout = function(val) {};
        
        me.getComment = function() {
            return opts.comment;  
        };
    
        me.getFontType = function() {
            return "aol";  
        };
    
        me.load = function(data) {
            data = data.replace(/\r\n/g,"\n").replace(/\r/g,"\n");
            
            var lines = data.split("\n");
            var headerData = lines.splice(0,1)[0].split(" ");
            var commentSize = parseInt(headerData[1], 10);
            
            opts = {};
            opts.height = parseInt(headerData[0], 10);
            opts.hasLowerCase = !!parseInt(headerData[2], 10);
            opts.hasNumbers = !!parseInt(headerData[3], 10);
            opts.comment = lines.splice(0,commentSize).join("\n");
            //console.dir(opts);

            bigChars = {};
            
            var charNums = [], cNum, ii;
            charNums.push(32);
            for (ii = 65; ii <= 90; ii++) {
                charNums.push(ii);
            }
            if (opts.hasLowerCase) {
                for (ii = 97; ii <= 122; ii++) {
                    charNums.push(ii);
                }
            }
            if (opts.hasNumbers) {
                for (ii = 48; ii <= 57; ii++) {
                    charNums.push(ii);
                }
            }
            bigChars.numChars = 0;
            
            var endCharRegEx;
            
            while (lines.length > 0 && bigChars.numChars < charNums.length) {
                cNum = charNums[bigChars.numChars];
                bigChars[cNum] = lines.splice(0,opts.height);
                bigChars.numChars++;
            }
            
            isFontLoaded = true;
        };
        
        me.getText = function(txt) {
            txt = txt.replace(/\r\n/g,"\n").replace(/\r/g,"\n");
            if (!opts.hasLowerCase) {
                txt = txt.toUpperCase();   
            }
            var lines = txt.split("\n");
            var bigLines = [];
            var ii;
            for (ii = 0; ii < lines.length; ii++) {
                bigLines.push( generateTextLine(lines[ii], bigChars, opts) );
            }
            return bigLines.join("\n").replace(new RegExp("\\"+opts.hardBlank,"g")," ");
        };
    };
})();