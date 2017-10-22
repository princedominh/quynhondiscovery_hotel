<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><h2><?php echo $title; ?></h2>

<table>
    <tr>
        <th>Icon</th>
        <th>Name</th>
        <th>Type</th>
        <th>Os</th>
        <th>Version</th>
        <th>Created Date</th>
    </tr>
</table>
<?php foreach ($data as $item): ?>
    <tr>
        <td><?php echo $item['icon']; ?></td>
        <td><?php echo $item['name']; ?></td>
        <td><?php echo $item['type_id']; ?></td>
        <td><?php echo $item['os_id']; ?></td>
        <td><?php echo $item['version']; ?></td>
        <td><?php echo $item['created_date']; ?></td>
    </tr>
<?php endforeach; ?>