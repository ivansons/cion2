<?php

namespace Drupal\cion_migrate\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;
use Drupal\migrate\Row;

/**
 * Source plugin for CION's Crew DB.
 *
 * @MigrateSource(
 *   id = "cion_crew"
 * )
 */
class cion_crew extends SqlBase {

  /**
   * {@inheritdoc}
   */
  public function query() {
    // Write a query using the standard Drupal query builder that will be run
    // against the {source} database to retrieve information about players. Each
    // row returned from the query should represent one item that we would like
    // to import. So, basically, one row per player.
    //
    // In this case, we can just select all rows from the master table in the
    // {source} database, and limit to just the fields we plan to migrate.
    $query = $this->select('auth_user', 'u')
      ->fields('u', array(
        'id',  
        'username',
        'first_name',
        'last_name',
        'email',
        'is_staff',
        'is_active',
        'date_joined',
        'last_login'
      ));
    return $query;
  }

  /**
   * {@inheritdoc}
   */
  public function fields() {
    // Provide documentation about source fields that are available for
    // mapping as key/value pairs. The key is the name of the field from the
    // database, and the value is the human readable description of the field.
    $fields = array(
      'id' => $this->t('ID'),
      'username' => $this->t('Username'),
      'fist_name' => $this->t('Fist Name'),
      'last_name' => $this->t('Last Name'),
      'email' => $this->t('Email Address'),
      'is_staff' => $this->t('Staff?'),
      'is_active' => $this->t('Active?'),
      'date_joined' => $this->t('Date joined'),
      'last_login' => $this->t('Last login')
    );

    // If using prepareRow() to create computed fields you can describe them
    // here as well.

    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function getIds() {
    // Use a Schema Definition array to describe the field from the source row
    // that will be used as the unique ID for each row.
    //
    // @link https://www.drupal.org/node/146939 - Schema array docs.
    //
    // @see \Drupal\migrate\Plugin\migrate\source\SqlBase::initializeIterator
    // for more about the 'alias' key.
    return [
      // Key is the name of the field from the fields() method above that we
      // want to use as the unique ID for each row.
      'id' => [
        // Type is from the schema array definition.
        'type' => 'integer',
        // This is an optional key currently only used by SqlBase.
        'alias' => 'u',
      ],
    ];
  }
}
