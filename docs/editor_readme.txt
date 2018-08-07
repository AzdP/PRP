  ____________________________________________________________________
 /                                                                    \
 |                        The PHP RPG Project                          |
 |                                                                     |
 |                 Version	: .85a                                 |
 |                 Author	: twoeyes                              |
 |                 Website	: www.xphpx.net                        |
 |                                                                     |
 \____________________________________________________________________/

			ABOUT THIS DOCUMENTATION: 
		This is a work in progress and you can expect
		a more complete one when the editor reaches 
				the 1.0 mark.

- What is it?
The editor is a powerful tool that you can use to modify the game world and 
change it to your liking.

- How do I use it?
Simply go to http://yoursite.com/prp_directory/cs/ to begin using the editor. A password can be set
via the editor.php file in the /cs/includes/ directory.

THE DEFAULT PASSWORD IS: prpeditor

- I'm logged in, now what?
Once you've logged in the system is basicly like playing the game normally, move the cursor over an
object and the grab button will become pressable. Press it and the object will be grabbed. Move your
cursor around some more and the object will "stick" to it. Press the drop object button or delete 
object button to stop changing it's position.

- How about adding items?
To add a terrain object click "Terrain" in the place items box. Fill out the form there to add
a new item.

- So how does this whole sector thing work?
Sectors aren't that hard to understand, basicly they're the divisions of the RPG system, each sector
has it's own background and set of objects and are totally seperate from the rest of the game world
unless you set a teleport sector, at which point the player can be transported to another sector
by going to the edge of the current map. It's up to you to correctly link sectors together. The reason
PRP is using this method instead of a more automated method is this way you can setup buildings and
define an interior sector which the user will be transported to upon touching the door. People are 
automatically transported out of buildings when they go to the bottom of the interior sector 50 pixels
below the defined door.

- Adding buildings
Adding buildings is basicly the same procedure as adding items, simply click the button to add a 
building and then follow the steps.

- Clipping
Clipping is the way you can keep a user from moving to a particular position on the map, such as a 
building or a rock. To place clippingpress the "toggle clipping" button on the left hand menu so 
that clipping is viewable, then press the Clip/Unclip button on the right hand side to "clip" something 
off.