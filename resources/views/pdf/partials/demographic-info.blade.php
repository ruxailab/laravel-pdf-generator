{{-- Demographic Information Section --}}
<?php
// Calculate first and last dates
$firstDate = null;
$lastDate = null;

foreach ($taskAnswers as $user) {
    if (!empty($user['lastUpdate'])) {
        $timestamp = $user['lastUpdate'];
        if ($firstDate === null || $timestamp < $firstDate) {
            $firstDate = $timestamp;
        }
        if ($lastDate === null || $timestamp > $lastDate) {
            $lastDate = $timestamp;
        }
    }
}

$firstDateFormatted = $firstDate ? date('d/m/Y', $firstDate / 1000) : '-';
$lastDateFormatted = $lastDate ? date('d/m/Y', $lastDate / 1000) : '-';

// Calculate unique number of tasks
$taskIds = [];
foreach ($taskAnswers as $user) {
    if (!empty($user['tasks'])) {
        foreach ($user['tasks'] as $task) {
            $taskId = $task['taskId'] ?? null;
            if ($taskId !== null && !in_array($taskId, $taskIds)) {
                $taskIds[] = $taskId;
            }
        }
    }
}
$uniqueTasks = count($taskIds);
?>

<h2>Información Demográfica</h2>
<table>
    <tr>
        <td style="width: 30%;"><strong>Número de Participantes:</strong></td>
        <td><strong>{{ $totalUsers }}</strong></td>
    </tr>
    <tr>
        <td><strong>Número de Tareas del Test:</strong></td>
        <td><strong>{{ $uniqueTasks }}</strong></td>
    </tr>
    <tr>
        <td><strong>Total de Tareas Realizadas:</strong></td>
        <td>{{ $totalTasks }} ({{ $totalUsers }} usuarios × {{ $uniqueTasks }} tareas)</td>
    </tr>
    <tr>
        <td><strong>Primera Respuesta:</strong></td>
        <td>{{ $firstDateFormatted }}</td>
    </tr>
    <tr>
        <td><strong>Última Respuesta:</strong></td>
        <td>{{ $lastDateFormatted }}</td>
    </tr>
    <tr>
        <td><strong>Tests Completados:</strong></td>
        <td>{{ $submittedUsers }} de {{ $totalUsers }} ({{ $submissionRate }}%)</td>
    </tr>
</table>
