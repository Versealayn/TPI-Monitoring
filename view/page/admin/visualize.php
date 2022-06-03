<?php 
echo'
<div class=bg-white\'>

<div class=\'overflow-x-auto border-x border-t\'>
   <table class=\'table-auto w-full\'>
      <thead class=\'border-b\'>
         <tr class=\'bg-gray-100\'>
            <th class=\'text-left p-4 font-medium\'>
               Tâche
            </th>';
            foreach ($students as $student)
            {
                echo'
                <th class=\'text-left p-4 font-medium\'>
                    '.$student['useSurname'].' '.$student['useName'].'
                </th>';
            }
            echo'
         </tr>
      </thead>
      <tbody>';
      foreach ($tasks as $task){
          echo '
          <tr class=\'border-b hover:bg-gray-50\'>
            <td class=\'p-4\'>
               '.$task['tasName'].'
            </td>';
      }
      echo'
      </tbody>
   </table>
</div>
</div>';
?>