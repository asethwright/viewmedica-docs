# ViewMedica 7 API Documentation

### Terminology

*Menu Structure*

1. Library - The top level taxonomy item in ViewMedica 7.
2. Collection - Subcategorizes libraries. For example, there are many collections in a library. If a collection is to be skipped, it is given the same name as the library.
3. Group - Typically groups are divided into either Procedures, Conditions, and Surgical Procedures/Non-surgical Procedures.
4. Item - A ViewMedica content item that can be viewed by the end user.

*Player Versions*

1. ViewMedica 7 - refers to the suite of both ViewMedica Flash and ViewMedica HTML. It is an attempt to have a version of ViewMedica which is supported on all devices.
2. ViewMedica HTML - The JavaScript and HTML version of ViewMedica which was released in 2013. This version of ViewMedica is being actively developed.
3. ViewMedica Flash - The deprecated version of ViewMedica which is written in ActionScript. This player is no longer supported but is maintained for supporting video playback in IE8 and lower.
4. ViewMedica Mobile - A paid service which allows users to play videos from their device without an internet connection. It can be downloaded from the App Store. Mirroring is also required and can be purchased from the user's viewmedica.com account.
5. ViewMedica DVD/CCTV - Products for in-office or waiting room use of the ViewMedica player and require no internet connection.

### Embed Variables

* A basic embed is listed below to give context for the rest of the configuration options. This embed will open the ViewMedica 7 viewer in its default state with navigation menus.

```
<!-- ViewMedica Embed Start -->
<div id="vm"></div>
<script type="text/javascript" src="https://www.swarminteractive.com/js/vm.js"></script>
<script type="text/javascript">client="1234"; width=580; vm_open();</script>
<!-- ViewMedica Embed End -->
```

- __Client ID__ *string*

Global variable which loads a preferences file into the ViewMedica viewer. All of these preferences can be overridden through embed variables. It is also used to determine what content a particular user has available.

```
ex.

client="1234";
```

- __Language__ *string*

Sets the language of the ViewMedica 7 viewer. This will override any option that has been selected through the users ViewMedica preferences panel at viewmedica.com. Only video items that have been translated in the selected language will be visible.

```
ex.

lang="es";
```

- __Width__ *int*

Sets the with of the ViewMedica player. The height will automatically be calculated from this value so that videos fit appropriately within the ViewMedica player.

```
ex.

width=580;
```

- __Openthis__ *string*

Tells the ViewMedica player either:

a. which content item it should open to and open in video mode
b. which library, collection, or group it should open to

A full list of openthis codes can be found in your viewmedica.com account under installation support.

```
ex.

openthis="A_123456"; //a video always starts with A_
openthis="L_123456"; //menu item locations may begin with L_ C_ or G_
```

- __Target__ *string*

Override the empty element that the ViewMedica player will be inserted in to. By default, the target is the same as the openthis code.

```
ex.

target_div="my_custom_div_id";
```

- __Disclaimer__ *boolean*

Whether or not the disclaimer should appear in the lower menu bar of the ViewMedica player.

```
ex.

disclaimer=false;
```

- __Menu Access__ *boolean*

By default, When the player is opened to video mode, users can exit the video interface and return to the default menu structure. Setting menuaccess to false disables these buttons and the player will always remain in single video mode.

```
ex.

menuaccess=false;
```

- __Captions__ *boolean*

Hide the closed captions toggle button.

```
ex.

captions=false;
```

- __Social__ *boolean*

Hide the social sharing (email, facebook, twitter) button.

```
ex.

social=false;
```

- __Secure__ *boolean*

Load all assets over HTTPS. By default, the ViewMedica player does not require a secure connection.

```
ex.

secure=true;
```

- __Ignore Audio__ *boolean*

The player is loaded in a muted state by default.

```
ex.

ignoreaudio=true;
```

- __Brochures__ *boolean*

Do not show the brochure printing buttons.

```
ex.

brochures=false;
```

- __Full Screen__ *boolean*

Hide the button which toggles full screen mode. This can be useful if the player is in a restricted iFrame and cannot be sized properly.

```
ex.

fullscreen=false;
```

