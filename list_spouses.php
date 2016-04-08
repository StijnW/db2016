<?php
	
$title = "Writers whose spouses are writers";
require("template/top.tpl.php");
require_once("gb/controller/getSpouseController.php");
require_once("gb/domain/Writer.php");
require_once("gb/mapper/WriterMapper.php");

$spouseController = new gb\controller\getSpouseController();
$spouseController->process();
?>    
<?php
$spouses = $spouseController->getSearchResult();
print count($spouses) . " Cases found";
if (count($spouses) > 0)
{?>
    <table style="width: 100%">
    <tr>
        <td>Writer</td>
        <td>Spouse</td>
        <td>Active From</td>  
        <td>Active To</td>
    </tr>    

<?php
		foreach($spouses as $spouse){
			?>
			<tr>
			<td><?php echo $spouse->getFullName(); ?></td>
				<td><?php echo $spouse->getSpouse(); ?></td>
				<td><?php echo $spouse->getActiveFrom(); ?></td>
				<td><?php echo $spouse->getActiveTo(); ?></td>
		</tr>
<?php
		}
?>
</table>
<?php
	}
?>
	
	
<?php
	require("template/bottom.tpl.php");
?>