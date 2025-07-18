<?php
function my_pagination($total, $limit, $page_limit, $page) {
  $total_page = ceil($total / $limit);
  $start_page = (floor(($page - 1) / $page_limit) * $page_limit) + 1;
  $end_page = $start_page + $page_limit - 1;
  if ($end_page > $total_page) $end_page = $total_page;

  $prev_page = $start_page - 1;
  $next_page = $end_page + 1;

  $output = '<div class="flex justify-center mt-8">';
  $output .= '<div class="flex space-x-2">';

  if ($start_page > 1) {
    $output .= '<a href="?page=1" class="px-3 py-1 bg-gray-700 hover:bg-blue-600 text-white rounded">First</a>';
    $output .= '<a href="?page=' . $prev_page . '" class="px-3 py-1 bg-gray-700 hover:bg-blue-600 text-white rounded">Prev</a>';
  }

  for ($i = $start_page; $i <= $end_page; $i++) {
    if ($i == $page) {
      $output .= '<span class="px-3 py-1 bg-blue-600 text-white rounded font-semibold">' . $i . '</span>';
    } else {
      $output .= '<a href="?page=' . $i . '" class="px-3 py-1 bg-gray-700 hover:bg-blue-600 text-white rounded">' . $i . '</a>';
    }
  }

  if ($next_page <= $total_page) {
    $output .= '<a href="?page=' . $next_page . '" class="px-3 py-1 bg-gray-700 hover:bg-blue-600 text-white rounded">Next</a>';
    $output .= '<a href="?page=' . $total_page . '" class="px-3 py-1 bg-gray-700 hover:bg-blue-600 text-white rounded">Last</a>';
  }

  $output .= '</div></div>';

  return $output;
}
?>