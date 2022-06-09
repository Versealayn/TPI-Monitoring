<?php 
echo'
<div class=bg-white\'>

<div class=\'overflow-x-auto border-x border-t\'>
   <h1 class=\'pt-4 text-gray-600 font-bold md:text-2xl text-xl\'>'.$project['proName'].'</h1>
   <h2 class=\'text-gray-500 font-bold md:text-md text-md\'>'. $project['proStart'] .' - '. $project['proEnd'] .'</h2>
   <h2 class=\'pb-4 text-gray-500 font-bold md:text-md text-md\'>'. $clagro['claName'].'</h2>
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