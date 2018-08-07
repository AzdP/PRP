<?php
require('includes/startup.php');

$page = new Template();

$page->simplePage('
<p><b>How do I move?<br>
</b>There are two ways to move in PRP, either by the compass located on the top
left of your screen, or via the keys W, A, S, and D (also known as WASD
movement). W is up, A is left, S is down, and D is right. Other controls include T for talk,
and F for fight.</p>
<p><b>How can I fight and talk to other characters?<br>
</b>If you notice on the left hand side of the interface you\'ll see a box
labeled &quot;actions&quot;, when something in this box lights up, or becomes colored, it
means that you can perform that action. For instance, if you move next to an NPC
(non-player character) the talk icon will light up, telling you that you can
talk to this person.</p>
<p><b>How do I fight?<br>
</b>Fighting is a very simple procedure. Simply walk up to a monster and press
the boxing glove to activate the fighting interface. To perform an attack,
simply select Punch, or the weapon you have equipped, and click &quot;attack&quot;.</p>
<p><b>What about bartering?<br>
</b>Bartering is just as easy as fighting, simply walk up to an NPC that offers bartering and click the talk button. You\'ll see
&quot;barter&quot; listed on the left menu. Click that to start buying stuff.</p>');
?>
