<?php

namespace Drupal\strayder\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides final form.
 */
class FormFinal extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'form_final';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Get the number of table, default to 1 table.
    $num_of_table = $form_state->get('num_of_table');
    if ($num_of_table === NULL) {
      $form_state->set('num_of_table', 1);
      $num_of_table = 1;
    }
    // Get the number of row, default to 1 row.
    $num_of_rows = $form_state->get('num_of_rows');
    if ($num_of_rows === NULL) {
      $form_state->set('num_of_rows', 1);
      $num_of_rows = 1;
    }
    // 'Add table' button.
    $form['actions']['add_table'] = [
      '#type' => 'submit',
      '#value' => $this->t('Add table'),
      '#submit' => ['::addTableCallback'],
      '#ajax' => [
        'callback' => '::ajaxAdd',
        'wrapper' => 'wrapper_form',
        'progress' => [
          'type' => 'none',
        ],
      ],
    ];
    // 'Add row' button.
    $form['actions']['add_row'] = [
      '#type' => 'submit',
      '#value' => $this->t('Add row'),
      '#submit' => ['::addRowCallback'],
      '#ajax' => [
        'callback' => '::ajaxAdd',
        'wrapper' => 'wrapper_form',
        'progress' => [
          'type' => 'none',
        ],
      ],
    ];
    // Submit button.
    $form['actions']['submit'] = [
      '#name'  => 'Submit',
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
      '#ajax' => [
        'callback' => '::ajaxAdd',
        'wrapper' => 'wrapper_form',
        'progress' => [
          'type' => 'none',
        ],
      ],
    ];
    $form['cell'] = [
      '#type' => 'markaup',
      '#prefix' => '<div id="wrapper_form">',
      '#suffix' => '</div>',
    ];
    for ($table = 0; $table < $num_of_table; $table++) {
      // To go through a full tree.
      $form['#tree'] = TRUE;
      // Add the headers.
      $form['cell'][$table] = [
        '#type' => 'table',
        '#header' => [
          'Year',
          'Jan',
          'Feb',
          'Mar',
          'Q1',
          'Apr',
          'May',
          'Jun',
          'Q2',
          'Jul',
          'Aug',
          'Sep',
          'Q3',
          'Oct',
          'Nov',
          'Dec',
          'Q4',
          'YTD',
        ],
      ];
      $year = (int) ((date('Y')));
      // Create rows according to $num_of_rows.
      for ($row = 0; $row < $num_of_rows; $row++) {
        $form['cell'][$table][$row]['Year'] = [
          '#type' => 'number',
          '#default_value' => $year + $row,
          '#disabled' => TRUE,
        ];
        $form['cell'][$table][$row]['Jan'] = [
          '#type' => 'number',
          '#step' => 0.05,
        ];
        $form['cell'][$table][$row]['Feb'] = [
          '#type' => 'number',
          '#step' => 0.05,
        ];
        $form['cell'][$table][$row]['Mar'] = [
          '#type' => 'number',
          '#step' => 0.05,
        ];
        $form['cell'][$table][$row]['q1'] = [
          '#type' => 'number',
          '#disabled' => TRUE,
        ];
        $form['cell'][$table][$row]['Apr'] = [
          '#type' => 'number',
          '#step' => 0.05,
        ];
        $form['cell'][$table][$row]['May'] = [
          '#type' => 'number',
          '#step' => 0.05,
        ];
        $form['cell'][$table][$row]['Jun'] = [
          '#type' => 'number',
          '#step' => 0.05,
        ];
        $form['cell'][$table][$row]['q2'] = [
          '#type' => 'number',
          '#disabled' => TRUE,
        ];
        $form['cell'][$table][$row]['Jul'] = [
          '#type' => 'number',
          '#step' => 0.05,
        ];
        $form['cell'][$table][$row]['Aug'] = [
          '#type' => 'number',
          '#step' => 0.05,
        ];
        $form['cell'][$table][$row]['Sep'] = [
          '#type' => 'number',
          '#step' => 0.05,
        ];
        $form['cell'][$table][$row]['q3'] = [
          '#type' => 'number',
          '#disabled' => TRUE,
        ];
        $form['cell'][$table][$row]['Oct'] = [
          '#type' => 'number',
          '#step' => 0.05,
        ];
        $form['cell'][$table][$row]['Nov'] = [
          '#type' => 'number',
          '#step' => 0.05,
        ];
        $form['cell'][$table][$row]['Dec'] = [
          '#type' => 'number',
          '#step' => 0.05,
        ];
        $form['cell'][$table][$row]['q4'] = [
          '#type' => 'number',
          '#disabled' => TRUE,
        ];
        $form['cell'][$table][$row]['ytd'] = [
          '#type' => 'number',
          '#disabled' => TRUE,
        ];
      }
    }
    // Connecting styles.
    $form['#attached']['library'][] = 'strayder/strayder-style';
    return $form;
  }

  /**
   * AJAX adding table and row.
   *
   * {@inheritdoc}
   */
  public function ajaxAdd(array &$form, FormStateInterface $form_state) {
    $form = $form_state->getCompleteForm();
    return $form['cell'];
  }

  /**
   * Add new table.
   *
   * {@inheritdoc}
   */
  public function addRowCallback(array &$form, FormStateInterface $form_state) {
    // Increase by 1 the number of rows.
    $num_of_rows = $form_state->get('num_of_rows');
    $num_of_rows++;
    $form_state->set('num_of_rows', $num_of_rows);
    // Rebuild form with 1 extra row.
    $form_state->setRebuild();
  }

  /**
   * Add new row.
   *
   * {@inheritdoc}
   */
  public function addTableCallback(array &$form, FormStateInterface $form_state) {
    // Increase by 1 the number of tables.
    $num_of_table = $form_state->get('num_of_table');
    $num_of_table++;
    $form_state->set('num_of_table', $num_of_table);
    // Rebuild form with 1 extra table.
    $form_state->setRebuild();
  }

  /**
   * Ajax submit.
   */
  public function ajaxSubmit(array &$form, FormStateInterface $form_state) {
    $form = $form_state->getCompleteForm();
    return $form;
  }

  /**
   * Function to search for the first set value.
   */
  public function firstSetValue($data) {
    // $first_set = the first set value.
    foreach ($data as $first_set) {
      if ($first_set) {
        return array_search($first_set, $data);
      }
    }
    return NULL;
  }

  /**
   * Function to search for the last set value.
   */
  public function lastSetValue($data) {
    // $last_filled = the last filled value.
    $reversed_array = array_reverse($data);
    foreach ($reversed_array as $last_set) {
      if ($last_set) {
        return array_search($last_set, $reversed_array);
      }
    }
    return NULL;
  }

  /**
   * Validation form.
   *
   * String integrity check.
   * Combine all cells in one table into one array.
   * Compare the values from the first to the last filled value
   * of the first array with the second.
   * Delete the empty cells and compare the second array with the second.
   * Compare whether the number of elements of the first and second coincide.
   * If there are no empty cells - valid, if there are invalid.
   *
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // Obtaining data on tables and rows and reference data.
    $months = [
      'Jan',
      'Feb',
      'Mar',
      'Apr',
      'May',
      'Jun',
      'Jul',
      'Aug',
      'Sep',
      'Oct',
      'Nov',
      'Dec',
    ];
    $value  = $form_state->getUserInput()['cell'];
    $tables = $form_state->get('num_of_table');
    $rows   = $form_state->get('num_of_rows');
    // In order for the validation to work only when the button is pressed
    // submit.
    $triggered = $form_state->getTriggeringElement()['#name'];
    if ($triggered === 'Submit') {
      // Index 'c' = 'count'.
      for ($table_c = 0; $table_c < 1; $table_c++) {
        for ($rows_c = 0; $rows_c < $rows; $rows_c++) {
          // $value_s = separate value.
          $value_c = $value[$table_c][$rows_c];
          foreach ($value_c as $value_s) {
            $user_input[] = $value_s;
          }
          // Getting the cells values.
          for ($cell_c = 0; $cell_c < count($months); $cell_c++) {
            // Table validation.
            if ($tables > 0) {
              $cell = $months[$cell_c];
              // $first_table = the first table  for comparison.
              $first_table = $value[$table_c][$rows_c][$cell];
              // Index $n = number of table.
              for ($t = 0; $t < $tables; $t++) {
                // $next_table = the second table for comparison.
                $next_table = $value[$table_c + $t][$rows_c][$cell];
                if (empty($first_table) xor empty($next_table)
                  ) {
                  return $form_state->setErrorByName('validation', $this->t(
                    'Invalid'));
                }
              }
            }
          }
        }
        // $length_data = the length of the entered data.
        $length_data = count($user_input);
        // $first_set = the first set value.
        $first_set = $this->firstSetValue($user_input);
        // $last_filled = the last set value.
        $last_set = $this->lastSetValue($user_input);
        // $segment_data = the segment of the entered data.
        $segment_data = $length_data - $first_set - $last_set;
        // $pre_filter = the entered data is pre-filtered.
        $pre_filter = array_slice($user_input,
          $first_set, $segment_data);
        // $filter = the entered data is filtered.
        $filter = array_filter($pre_filter);
        if (count($pre_filter) !== count($filter)) {
          return $form_state->setErrorByName('validation', $this->t(
            'Invalid'));
        }
      }
      return $this->messenger()->addStatus($this->t('Valid'));
    }
    return $form;
  }

  /**
   * Submit.
   *
   * Divide the line into four parts of three elements, each part is one
   * quarter.
   * Count the amount of three months and write it in the appropriate quarter.
   * Add quarters and get the value of the year.
   *
   * {@inheritDoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Values entered by the user.
    $value = $form_state->getUserInput()['cell'];
    $quarters = ['q1', 'q2', 'q3', 'q4'];
    // $array_part = each array has three elements.
    // Index 'q' = quarter
    $array_part = [];
    foreach ($value as $key => $table) {
      foreach ($table as $row) {
        $array_part[$key][] = array_chunk($row, 3);
      }
    }
    // Check if the cells are not empty.
    // We write each array_part in a separate variable.
    $q_all = [];
    $year = [];
    foreach ($array_part as $key => $table) {
      foreach ($table as $year_key => $year) {
        foreach ($year as $q_key => $quarter) {
          if (array_sum($quarter) > 0) {
            $q_all[$key][$year_key][$q_key] = sprintf('%0.2f', (array_sum($quarter) + 1) / 3);
          }
        }
      }
    }
    // Filling quarters with data.
    foreach ($q_all as $key => $table) {
      foreach ($table as $year_key => $row) {
        foreach ($row as $q_key => $quarter) {
          if (!empty($quarter)) {
            $form['cell'][$key][$year_key][$quarters[$q_key]]['#value'] = $quarter;
          }
        }
      }
    }
    // Checking the values of quarters.
    // Combining quarters to a separate shift.
    foreach ($q_all as $key => $table) {
      foreach ($table as $year_key => $row) {
        if (array_sum($row) > 0) {
          $year[$key][$year_key] = sprintf('%0.2f', (array_sum($row) + 1) / 4);
        }
      }
    }
    // Filling the cell with the year.
    foreach ($year as $key => $table) {
      foreach ($table as $year_key => $row) {
        if ($row > 0) {
          $form['cell'][$key][$year_key]['ytd']['#value'] = $row;
        }
      }
    }
    return $form;
  }

}
