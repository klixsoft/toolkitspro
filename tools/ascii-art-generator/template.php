<style>
.modal__actions-helper code {
    border: 1px solid;
    padding: 2px 4px;
    border-radius: 4px;
}

.modal__actions-button {
    position: relative;
    display: flex;
    align-items: center;
    margin-left: auto;
    padding: 0 12px;
    background: #fff;
    border: 1px solid var(--primary);
    border-radius: 0;
    color: #2A81FB;
    font-size: 11px;
    font-weight: bold;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    overflow: hidden;
    cursor: pointer;
    transition: all 250ms ease-out;
    padding: 5px 12px;
}

.modal__actions-button span {
    margin-left: 6px;
}

.modal__actions-button-copied {
    display: flex;
    align-items: center;
    justify-content: center;
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: var(--primary);
    border: 1px solid var(--primary);
    border-radius: 0;
    color: #fff;
    transform: translateY(105%);
    transition: all 250ms ease-out;
}

.ascii-text-art_copy.active .modal__actions-button-copied,
.ascii-text-art_download.active .modal__actions-button-copied {
    transform: translateY(0%);
}

.modal__actions-button{
    color: var(--primary);
}

.modal__actions-button i {
    font-size: 18px;
}

.modal__actions {
    display: flex;
    align-items: center;
    background: #E0E8F3;
    padding: 12px 24px;
    justify-content: space-between;
}

.footer_button_row {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 5px;
}

#outputFigDisplay pre {
    background-color: #e9ecef;
    opacity: 1;
    box-sizing: border-box;
    border-radius: 5px 5px 0 0;
    padding: 13px 15px;
    min-height: 50px;
    width: 100%;
    margin: 0;
    outline: none;
    box-shadow: none;
}
</style>

<div class="ascii-art-generator_content">
    <div class="ascii-art-generator_submit_form">
        <div class="form-group">
            <label>Enter Text</label>
            <div class="ascii-art-generator_input_container">
                <textarea rows="2" class="form-control" id="inputText" type="text"
                    placeholder="Enter text...">Type Something</textarea>
            </div>
        </div>

        <div class="accordion mt-4" id="minifyHTMLAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Options
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                    data-bs-parent="#minifyHTMLAccordion">
                    <div class="accordion-body">
                        <div class="row">
                            <div class="col-md-4 mt-1">
                                <div class="form-group">
                                    <label>Font</label>
                                    <select id="fontList" class="form-control">
                                        <optgroup label="Featured FIGlet Fonts">
                                            <option value="3D Diagonal.flf">3D Diagonal</option>
                                            <option value="Alpha.flf">Alpha</option>
                                            <option value="Acrobatic.flf">Acrobatic</option>
                                            <option value="Avatar.flf">Avatar</option>
                                            <option value="babyface-lame.flf">Babyface Lame</option>
                                            <option value="babyface-leet.flf">Babyface Leet</option>
                                            <option value="Big Money-ne.flf">Big Money-ne</option>
                                            <option value="Big Money-nw.flf">Big Money-nw</option>
                                            <option value="Big Money-se.flf">Big Money-se</option>
                                            <option value="Big Money-sw.flf">Big Money-sw</option>
                                            <option value="Big.flf">Big</option>
                                            <option value="Blocks.flf">Blocks</option>
                                            <option value="Bulbhead.flf">Bulbhead</option>
                                            <option value="Cards.flf">Cards</option>
                                            <option value="Chiseled.flf">Chiseled</option>
                                            <option value="Crawford2.flf">Crawford2</option>
                                            <option value="Crazy.flf">Crazy</option>
                                            <option value="Dancing Font.flf">Dancing Font</option>
                                            <option value="Doh.flf">Doh</option>
                                            <option value="Doom.flf">Doom</option>
                                            <option value="Efti Wall.flf">Efti Wall</option>
                                            <option value="Epic.flf">Epic</option>
                                            <option value="Fire Font-k.flf">Fire Font-k</option>
                                            <option value="Fire Font-s.flf">Fire Font-s</option>
                                            <option value="Flower Power.flf">Flower Power</option>
                                            <option value="Fun Face.flf">Fun Face</option>
                                            <option value="Fun Faces.flf">Fun Faces</option>
                                            <option value="Ghost.flf">Ghost</option>
                                            <option value="Graceful.flf">Graceful</option>
                                            <option value="Graffiti.flf" selected="">Graffiti</option>
                                            <option value="Impossible.flf">Impossible</option>
                                            <option value="Isometric1.flf">Isometric1</option>
                                            <option value="Isometric2.flf">Isometric2</option>
                                            <option value="Isometric3.flf">Isometric3</option>
                                            <option value="Isometric4.flf">Isometric4</option>
                                            <option value="JS Bracket Letters.flf">JS Bracket Letters</option>
                                            <option value="Lil Devil.flf">Lil Devil</option>
                                            <option value="Merlin1.flf">Merlin1</option>
                                            <option value="Modular.flf">Modular</option>
                                            <option value="Ogre.flf">Ogre</option>
                                            <option value="Patorjk's Cheese.flf">Patorjk's Cheese</option>
                                            <option value="Patorjk-HeX.flf">Patorjk-HeX</option>
                                            <option value="Rectangles.flf">Rectangles</option>
                                            <option value="Slant.flf">Slant</option>
                                            <option value="Slant Relief.flf">Slant Relief</option>
                                            <option value="Small.flf">Small</option>
                                            <option value="Small Slant.flf">Small Slant</option>
                                            <option value="Small Isometric1.flf">Small Isometric1</option>
                                            <option value="Soft.flf">Soft</option>
                                            <option value="Standard.flf">Standard</option>
                                            <option value="Star Wars.flf">Star Wars</option>
                                            <option value="Sub-Zero.flf">Sub-Zero</option>
                                            <option value="Swamp Land.flf">Swamp Land</option>
                                            <option value="Sweet.flf">Sweet</option>
                                            <option value="Train.flf">Train</option>
                                            <option value="Twisted.flf">Twisted</option>
                                            <option value="Wet Letter.flf">Wet Letter</option>
                                            <option value="Varsity.flf">Varsity</option>
                                        </optgroup>
                                        <optgroup label="ANSI FIGlet Fonts">
                                            <option value="3D-ASCII.flf">3D-ASCII</option>
                                            <option value="ANSI Regular.flf">ANSI Regular</option>
                                            <option value="ANSI Shadow.flf">ANSI Shadow</option>
                                            <option value="Bloody.flf">Bloody</option>
                                            <option value="Calvin S.flf">Calvin S</option>
                                            <option value="Delta Corps Priest 1.flf">Delta Corps Priest 1</option>
                                            <option value="Electronic.flf">Electronic</option>
                                            <option value="Elite.flf">Elite</option>
                                            <option value="Stronger Than All.flf">Stronger Than All</option>
                                            <option value="THIS.flf">THIS</option>
                                            <option value="The Edge.flf">The Edge</option>
                                        </optgroup>
                                        <optgroup label="Regular FIGlet Fonts">
                                            <option value="1Row.flf">1Row</option>
                                            <option value="3-D.flf">3-D</option>
                                            <option value="3x5.flf">3x5</option>
                                            <option value="4Max.flf">4Max</option>
                                            <option value="5 Line Oblique.flf">5 Line Oblique</option>
                                            <option value="AMC 3 Line.flf">AMC 3 Line</option>
                                            <option value="AMC 3 Liv1.flf">AMC 3 Liv1</option>
                                            <option value="AMC AAA01.flf">AMC AAA01</option>
                                            <option value="AMC Neko.flf">AMC Neko</option>
                                            <option value="AMC Razor.flf">AMC Razor</option>
                                            <option value="AMC Razor2.flf">AMC Razor2</option>
                                            <option value="AMC Slash.flf">AMC Slash</option>
                                            <option value="AMC Slider.flf">AMC Slider</option>
                                            <option value="AMC Thin.flf">AMC Thin</option>
                                            <option value="AMC Tubes.flf">AMC Tubes</option>
                                            <option value="AMC Untitled.flf">AMC Untitled</option>
                                            <option value="ASCII New Roman.flf">ASCII New Roman</option>
                                            <option value="Alligator.flf">Alligator</option>
                                            <option value="Alligator2.flf">Alligator2</option>
                                            <option value="Alphabet.flf">Alphabet</option>
                                            <option value="Arrows.flf">Arrows</option>
                                            <!--<option value="B1FF.flf">B1FF</option>-->
                                            <option value="Banner.flf">Banner</option>
                                            <option value="Banner3-D.flf">Banner3-D</option>
                                            <option value="Banner3.flf">Banner3</option>
                                            <option value="Banner4.flf">Banner4</option>
                                            <option value="Barbwire.flf">Barbwire</option>
                                            <option value="Basic.flf">Basic</option>
                                            <option value="Bear.flf">Bear</option>
                                            <option value="Bell.flf">Bell</option>
                                            <option value="Benjamin.flf">Benjamin</option>
                                            <option value="Big Chief.flf">Big Chief</option>
                                            <option value="Bigfig.flf">Bigfig</option>
                                            <option value="Binary.flf">Binary</option>
                                            <option value="Block.flf">Block</option>
                                            <option value="Bolger.flf">Bolger</option>
                                            <option value="Braced.flf">Braced</option>
                                            <option value="Bright.flf">Bright</option>
                                            <option value="Broadway KB.flf">Broadway KB</option>
                                            <option value="Broadway.flf">Broadway</option>
                                            <option value="Bubble.flf">Bubble</option>
                                            <option value="Caligraphy.flf">Caligraphy</option>
                                            <option value="Caligraphy2.flf">Caligraphy2</option>
                                            <option value="Catwalk.flf">Catwalk</option>
                                            <option value="Chunky.flf">Chunky</option>
                                            <option value="Coinstak.flf">Coinstak</option>
                                            <option value="Cola.flf">Cola</option>
                                            <option value="Colossal.flf">Colossal</option>
                                            <option value="Computer.flf">Computer</option>
                                            <option value="Contessa.flf">Contessa</option>
                                            <option value="Contrast.flf">Contrast</option>
                                            <option value="Cosmike.flf">Cosmike</option>
                                            <option value="Crawford.flf">Crawford</option>
                                            <option value="Cricket.flf">Cricket</option>
                                            <option value="Cursive.flf">Cursive</option>
                                            <option value="Cyberlarge.flf">Cyberlarge</option>
                                            <option value="Cybermedium.flf">Cybermedium</option>
                                            <option value="Cybersmall.flf">Cybersmall</option>
                                            <option value="Cygnet.flf">Cygnet</option>
                                            <option value="DANC4.flf">DANC4</option>
                                            <option value="DWhistled.flf">DWhistled</option>

                                            <option value="Decimal.flf">Decimal</option>
                                            <option value="Def Leppard.flf">Def Leppard</option>
                                            <option value="Diamond.flf">Diamond</option>
                                            <option value="Diet Cola.flf">Diet Cola</option>
                                            <option value="Digital.flf">Digital</option>
                                            <option value="Dot Matrix.flf">Dot Matrix</option>
                                            <option value="Double Shorts.flf">Double Shorts</option>
                                            <option value="Double.flf">Double</option>
                                            <option value="Dr Pepper.flf">Dr Pepper</option>
                                            <option value="Efti Chess.flf">Efti Chess</option>
                                            <option value="Efti Font.flf">Efti Font</option>
                                            <option value="Efti Italic.flf">Efti Italic</option>
                                            <option value="Efti Piti.flf">Efti Piti</option>
                                            <option value="Efti Robot.flf">Efti Robot</option>
                                            <option value="Efti Water.flf">Efti Water</option>
                                            <option value="Fender.flf">Fender</option>
                                            <option value="Filter.flf">Filter</option>
                                            <option value="Flipped.flf">Flipped</option>
                                            <option value="Four Tops.flf">Four Tops</option>
                                            <option value="Fraktur.flf">Fraktur</option>
                                            <option value="Fuzzy.flf">Fuzzy</option>
                                            <option value="Georgi16.flf">Georgi16</option>
                                            <option value="Georgia11.flf">Georgia11</option>
                                            <option value="Ghoulish.flf">Ghoulish</option>
                                            <option value="Glenyn.flf">Glenyn</option>
                                            <option value="Goofy.flf">Goofy</option>
                                            <option value="Gothic.flf">Gothic</option>
                                            <option value="Gradient.flf">Gradient</option>
                                            <option value="Greek.flf">Greek</option>
                                            <option value="Heart Left.flf">Heart Left</option>
                                            <option value="Heart Right.flf">Heart Right</option>
                                            <option value="Henry 3D.flf">Henry 3D</option>
                                            <option value="Hex.flf">Hex</option>
                                            <option value="Hieroglyphs.flf">Hieroglyphs</option>
                                            <option value="Hollywood.flf">Hollywood</option>
                                            <option value="Horizontal Left.flf">Horizontal Left</option>
                                            <option value="Horizontal Right.flf">Horizontal Right</option>
                                            <option value="ICL-1900.flf">ICL-1900</option>
                                            <option value="Invita.flf">Invita</option>

                                            <option value="Italic.flf">Italic</option>
                                            <option value="Ivrit.flf">Ivrit</option>
                                            <option value="JS Block Letters.flf">JS Block Letters</option>
                                            <option value="JS Capital Curves.flf">JS Capital Curves</option>
                                            <option value="JS Cursive.flf">JS Cursive</option>
                                            <option value="JS Stick Letters.flf">JS Stick Letters</option>
                                            <option value="Jacky.flf">Jacky</option>
                                            <option value="Jazmine.flf">Jazmine</option>
                                            <option value="Jerusalem.flf">Jerusalem</option>
                                            <option value="Katakana.flf">Katakana</option>
                                            <option value="Kban.flf">Kban</option>
                                            <option value="Keyboard.flf">Keyboard</option>
                                            <option value="Knob.flf">Knob</option>
                                            <option value="LCD.flf">LCD</option>
                                            <option value="Larry 3D.flf">Larry 3D</option>
                                            <option value="Lean.flf">Lean</option>
                                            <option value="Letters.flf">Letters</option>
                                            <option value="Line Blocks.flf">Line Blocks</option>
                                            <option value="Linux.flf">Linux</option>
                                            <option value="Lockergnome.flf">Lockergnome</option>
                                            <option value="Madrid.flf">Madrid</option>
                                            <option value="Marquee.flf">Marquee</option>
                                            <option value="Maxfour.flf">Maxfour</option>
                                            <option value="Merlin2.flf">Merlin2</option>
                                            <option value="Mike.flf">Mike</option>
                                            <option value="Mini.flf">Mini</option>
                                            <option value="Mirror.flf">Mirror</option>
                                            <option value="Mnemonic.flf">Mnemonic</option>
                                            <option value="Morse.flf">Morse</option>
                                            <option value="Moscow.flf">Moscow</option>
                                            <option value="Mshebrew210.flf">Mshebrew210</option>
                                            <option value="Muzzle.flf">Muzzle</option>
                                            <option value="NScript.flf">NScript</option>
                                            <option value="NT Greek.flf">NT Greek</option>
                                            <option value="NV Script.flf">NV Script</option>
                                            <option value="Nancyj-Fancy.flf">Nancyj-Fancy</option>
                                            <option value="Nancyj-Underlined.flf">Nancyj-Underlined</option>
                                            <option value="Nancyj.flf">Nancyj</option>
                                            <option value="Nipples.flf">Nipples</option>
                                            <option value="O8.flf">O8</option>
                                            <option value="OS2.flf">OS2</option>
                                            <option value="Octal.flf">Octal</option>
                                            <option value="Old Banner.flf">Old Banner</option>
                                            <option value="Pawp.flf">Pawp</option>
                                            <option value="Peaks Slant.flf">Peaks Slant</option>
                                            <option value="Peaks.flf">Peaks</option>
                                            <option value="Pebbles.flf">Pebbles</option>
                                            <option value="Pepper.flf">Pepper</option>
                                            <option value="Poison.flf">Poison</option>
                                            <option value="Puffy.flf">Puffy</option>
                                            <option value="Puzzle.flf">Puzzle</option>
                                            <option value="Pyramid.flf">Pyramid</option>
                                            <option value="Rammstein.flf">Rammstein</option>
                                            <option value="Relief.flf">Relief</option>
                                            <option value="Relief2.flf">Relief2</option>
                                            <option value="Reverse.flf">Reverse</option>
                                            <option value="Roman.flf">Roman</option>
                                            <!--<option value="Rot13.flf">Rot13</option>-->
                                            <option value="Rotated.flf">Rotated</option>
                                            <option value="Rounded.flf">Rounded</option>
                                            <option value="Rowan Cap.flf">Rowan Cap</option>
                                            <option value="Rozzo.flf">Rozzo</option>
                                            <option value="Runic.flf">Runic</option>
                                            <option value="Runyc.flf">Runyc</option>
                                            <option value="S Blood.flf">S Blood</option>
                                            <option value="SL Script.flf">SL Script</option>
                                            <option value="Santa Clara.flf">Santa Clara</option>
                                            <option value="Script.flf">Script</option>
                                            <option value="Serifcap.flf">Serifcap</option>
                                            <option value="Shadow.flf">Shadow</option>
                                            <option value="Shimrod.flf">Shimrod</option>
                                            <option value="Short.flf">Short</option>
                                            <option value="Slide.flf">Slide</option>
                                            <option value="Small Caps.flf">Small Caps</option>
                                            <option value="Small Keyboard.flf">Small Keyboard</option>
                                            <option value="Small Poison.flf">Small Poison</option>
                                            <option value="Small Script.flf">Small Script</option>
                                            <option value="Small Shadow.flf">Small Shadow</option>
                                            <option value="Small Tengwar.flf">Small Tengwar</option>
                                            <option value="Speed.flf">Speed</option>
                                            <option value="Spliff.flf">Spliff</option>
                                            <option value="Stacey.flf">Stacey</option>
                                            <option value="Stampate.flf">Stampate</option>
                                            <option value="Stampatello.flf">Stampatello</option>
                                            <option value="Star Strips.flf">Star Strips</option>
                                            <option value="Stellar.flf">Stellar</option>
                                            <option value="Stforek.flf">Stforek</option>
                                            <option value="Stick Letters.flf">Stick Letters</option>
                                            <option value="Stop.flf">Stop</option>
                                            <option value="Straight.flf">Straight</option>
                                            <option value="Swan.flf">Swan</option>
                                            <option value="Tanja.flf">Tanja</option>
                                            <option value="Tengwar.flf">Tengwar</option>
                                            <option value="Term.flf">Term</option>
                                            <option value="Test1.flf">Test1</option>
                                            <option value="Thick.flf">Thick</option>
                                            <option value="Thin.flf">Thin</option>
                                            <option value="Thorned.flf">Thorned</option>
                                            <option value="Three Point.flf">Three Point</option>
                                            <option value="Ticks Slant.flf">Ticks Slant</option>
                                            <option value="Ticks.flf">Ticks</option>
                                            <option value="Tiles.flf">Tiles</option>
                                            <option value="Tinker-Toy.flf">Tinker-Toy</option>
                                            <option value="Tombstone.flf">Tombstone</option>
                                            <option value="Trek.flf">Trek</option>
                                            <option value="Tsalagi.flf">Tsalagi</option>
                                            <option value="Tubular.flf">Tubular</option>
                                            <option value="Two Point.flf">Two Point</option>
                                            <option value="USA Flag.flf">USA Flag</option>
                                            <option value="Univers.flf">Univers</option>
                                            <option value="Wavy.flf">Wavy</option>
                                            <option value="Weird.flf">Weird</option>
                                            <option value="Whimsy.flf">Whimsy</option>
                                            <option value="Wow.flf">Wow</option>
                                        </optgroup>
                                        <optgroup label="AOL Macro Fonts">
                                            <option value="Abraxis-Big.aol">Abraxis-Big</option>
                                            <option value="Abraxis-Small.aol">Abraxis-Small</option>
                                            <option value="Bent.aol">Bent</option>
                                            <option value="Blest.aol">Blest</option>
                                            <option value="Boie.aol">Boie</option>
                                            <option value="Boie2.aol">Boie2</option>
                                            <option value="Bone's Font.aol">Bone's Font</option>
                                            <option value="CaMiZ.aol">CaMiZ</option>
                                            <option value="CeA.aol">CeA</option>
                                            <option value="CeA2.aol">CeA2</option>
                                            <option value="Cheese.aol">Cheese</option>
                                            <option value="DaiR.aol">DaiR</option>
                                            <option value="Filth.aol">Filth</option>
                                            <option value="FoGG.aol">FoGG</option>
                                            <option value="Galactus.aol">Galactus</option>
                                            <option value="Glue.aol">Glue</option>
                                            <option value="HeX's Font.aol">HeX's Font</option>
                                            <option value="Hellfire.aol">Hellfire</option>
                                            <option value="MeDi.aol">MeDi</option>
                                            <option value="Mer.aol">Mer</option>
                                            <option value="PsY.aol">PsY</option>
                                            <option value="PsY2.aol">PsY2</option>
                                            <option value="Reeko Font 1.aol">Reeko Font 1</option>
                                            <option value="Ribbit.aol">Ribbit</option>
                                            <option value="Ribbit2.aol">Ribbit2</option>
                                            <option value="Ribbit3.aol">Ribbit3</option>
                                            <option value="Sony.aol">Sony</option>
                                            <option value="TRaC Mini.aol">TRaC Mini</option>
                                            <option value="TRaC Tiny.aol">TRaC Tiny</option>
                                            <option value="TRaC's Old School Font.aol">TRaC's Old School Font</option>
                                            <option value="TRaC.aol">TRaC</option>
                                            <option value="Twiggy.aol">Twiggy</option>
                                            <option value="X-Pose.aol">X-Pose</option>
                                            <option value="X99.aol">X99</option>
                                            <option value="X992.aol">X992</option>
                                            <option value="Zodi.aol">Zodi</option>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 mt-1">
                                <div class="form-group">
                                    <label>Font Width</label>
                                    <select id="taagCharWidth" class="form-control">
                                        <option value="full">Full</option>
                                        <option value="fitted">Fitted</option>
                                        <option value="controlled smushing">Smush (R)</option>
                                        <option value="universal smushing">Smush (U)</option>
                                        <option value="default" selected="">Default</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 mt-1">
                                <div class="form-group">
                                    <label>Font Height</label>
                                    <select id="taagCharHeight" class="form-control">
                                        <option value="full">Full</option>
                                        <option value="fitted">Fitted</option>
                                        <option value="controlled smushing">Smush (R)</option>
                                        <option value="universal smushing">Smush (U)</option>
                                        <option value="default" selected="">Default</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="form-group mt-4">
            <label>Result</label>
            <div class="ascii-text-art_report_container">
                <div class="ascii-text-art_report">
                    <div id="outputFigDisplay"></div>
                    <div class="modal__actions">
                        <div class="modal__actions-helper">
                            ASCII Art Result <code>banner.txt</code>
                        </div>
                        <div class="footer_button_row">
                            <button type="button" class="modal__actions-button ascii-text-art_info">
                                <i class="las la-info-circle"></i>
                                <span>Font Info</span>
                            </button>

                            <button type="button" class="modal__actions-button ascii-text-art_copy">
                                <i class="las la-code"></i>
                                <span>Copy</span>
                                <div class="modal__actions-button-copied js-copied">Copied!</div>
                            </button>

                            <button type="button" class="modal__actions-button ascii-text-art_download">
                                <i class="las la-download"></i>
                                <span>Download</span>
                                <div class="modal__actions-button-copied js-copied">Downloaded!</div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>