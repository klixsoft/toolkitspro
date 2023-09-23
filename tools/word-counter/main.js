$(document).ready(function () {
    const num_word = $(document).find("#num_word");
    const num_character = $(document).find("#num_character");
    const num_sentence = $(document).find("#num_sentence");
    const read_time = $(document).find("#read_time");

    function formatNumber(num) {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
    }

    function countCharacters(text) {
        var temp;
        return text.length < 1e5 ?
            null !== (temp = text.match(/(?:[^\r\n]|\r(?!\n))/g)) ?
                temp.length
                :
                0
            : text.length;
    }

    function countWords(text) {
        var temp = wordsOfText(text);
        return null !== temp ? temp.length : 0;
    }

    function wordsOfText(text) {
        var temp;
        return !1 ==
            (null ===
                (temp = text.replace(/\s+/g, "").match(/([^\x00-\x7F\u2013\u2014])+/gi)))
            ? text.match(/\S+/g)
            : text
                .replace(/[;!:—\/]/g, " ")
                .replace(/\.\s+/g, " ")
                .replace(/[^a-zA-Z\d\s&:,]/g, "")
                .replace(/,([^0-9])/g, " $1")
                .match(/\S+/g);
    }

    function setupWordValue(text) {
        const words = countWords(text);

        num_word.html(formatNumber(words));
        num_character.html(formatNumber(countCharacters(text)));
        num_sentence.html(formatNumber(countSentences(text)));
        read_time.html(readingTime(words));
    }

    function countSentences(text) {
        var temp = text.match(/[^.!?][^.!?]*(?:[.!?](?!['"]?|$)[^.!?]*)*[.!?]?['"]?(?=|$)([.!?]\s+[A-Z0-9])/g);
        if (null !== temp) {
            for (var e = temp.length, r = 1, a = 0; a < e; a++)
                temp[a].match(/[0-9a-zA-Z]+/) && r++;
            return r;
        }
        return 0;
    }

    function spanWrap(n) {
        return "<span>" + n + "</span>";
      }
      
      function readingTime(t) {
        var e,
          r,
          a = t / 275;
        return a < 1
          ? Math.ceil(60 * a) + " " + spanWrap("sec")
          : a >= 1 && a < 60
          ? ((e = Math.floor((a = Math.round(100 * a) / 100))),
            (r = Math.round((a % 1) * 60)),
            e +
              " " +
              (1 == e ? spanWrap("min") : spanWrap("mins")) +
              " " +
              r +
              " " +
              spanWrap("sec"))
          : ((e = Math.floor((a = Math.round((a / 60) * 100) / 100))),
            (r = Math.round((a % 1) * 60)),
            e +
              " " +
              (1 == e ? spanWrap("hr") : spanWrap("hrs")) +
              " " +
              r +
              " " +
              (r <= 1 ? spanWrap("min") : spanWrap("mins")));
      }

    function countCharactersWithoutSpaces(text) {
        var temp = text.match(/\S/g);
        return null !== temp ? temp.length : 0;
    }

    function removeUncountablePartsFromText(n) {
        for (var t = n, e = 0, r = 0, a = 0; ;)
            if (-1 !== t.indexOf("~~~")) {
                if (((a = (e = t.indexOf("~~~")) + 3), -1 !== t.indexOf("~~~", a)))
                    (r = t.indexOf("~~~", a) + 3), (t = t.slice(0, e) + t.slice(r));
                else break;
            } else break;
        return t;
    }

    $(document).on("change keyup paste keydown", "#inputText", function () {
        setupWordValue(removeUncountablePartsFromText($(this).val()));
    });
});