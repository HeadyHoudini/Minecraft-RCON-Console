/**
 * https://gist.github.com/Minecrell/755e53aced83ab48513f#gistcomment-3494152
 *
 * Copyright (c) 2013, Minecrell
 * MIT License: http://opensource.org/licenses/MIT
 */
$( document ).ready(()=> {

    $.each($('.mc-k'), (index , value) => {

        let colorAttr = $(value).children().attr('class');

        let characters = 'aáäâbcçdéëêfghiïíîjklmnoóöôøpqrsßtuúüûvwxyz1234567890',
            length = $(value).text().length;

        setInterval(() => {
            let newString = ' ';

            for (let i = 0; i < length; i++) {
                let newCharacter = characters[Math.floor(Math.random() * characters.length)];
                if (Math.random() > 0.5) newCharacter = newCharacter.toUpperCase();
                newString += newCharacter;
            }
            $(value).text(newString);
            $(value).attr('class', `mc-k ${colorAttr}`);

        }, 25)
    })
});