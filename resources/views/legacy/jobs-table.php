<!-- Main content -->
<section class="content">
<h1><?=$title?></h1>

<table class="jobs-table">
  <thead>
    <tr>
      <th>ID</th>
      <th>Title</th>
      <th>Material</th>
      <th>Time Remaining</th>
      <th>Status</th>
      <th>Length</th>
      <th>Warnings</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($list as $job): ?>
      <tr id="<?= $job['ID'] ?>">
        <td><?= $job['ID'] ?></td>
        <td><a href="?job=<?= $job['ID'] ?>"><?= $job['Title'] ?></td>
        <td>
          <?php if (!empty($job['Material'])): ?>
            <span class="<?= strtolower($job['Material']) ?>"><?= $job['Material'] ?></span>
          <?php else: ?>
          <?php endif; ?>
        </td>
        <td>
          <?php if ($job['EstimatedHours'] == 0): ?>
            <span>Time and Material</span>
          <?php else: ?>
            <span>
              <?= $job['ActualHours'] ?> / <?= $job['EstimatedHours'] ?> hours (<?= round(($job['ActualHours'] / $job['EstimatedHours']) * 100, 1) ?>%)
            </span>
          <?php endif; ?>
        </td>
        <td><?= $job['StatusName'] ?></td>
        <td>
          <?php if (!empty($job['Length'])): ?>
            <span><?= $job['Length'] ?> feet</span>
          <?php endif; ?>
        </td>
        <td>
          <?php if (empty($job['Material'])): ?>
            Unknown material
          <?php endif; ?>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

</section>