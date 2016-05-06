<?php
/*
This file is part of VCMS.

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA
*/

if(!is_object($libGlobal))
	exit();

if($libGenericStorage->loadValueInCurrentModule('fb:admins') == ''){
	$libGenericStorage->saveValueInCurrentModule('fb:admins', 0);
}
?>
<h1>Willkommen</h1>

<table>
	<tr>
		<td>
			<table>
			<?php include("elements/announcements.php"); ?>
			</table>
		</td>
		<td>
			<table>
				<tr>
					<th>Aktuelles</th>
				</tr>
				<tr>
					<td class="rechteSpalteBox">
						<?php include("elements/nextevent.php");?>
						<?php include("elements/socialmedia.php");?>
					</td>
				</tr>
<?php
require("elements/randomimage.php");

if(is_file($libModuleHandler->getModuleDirectory()."custom/rechtespalte.php")){
	include($libModuleHandler->getModuleDirectory()."custom/rechtespalte.php");
}
?>
			</table>
      	</td>
	</tr>
</table>