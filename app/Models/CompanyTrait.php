<?php namespace App\Models;

use Auth;

trait CompanyTrait {

    /**
     * Gets the associated company.
     *
     * @return Company
     */
    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }

    /**
     * Filters query by the current user's company id.
     *
     * @param  Builder  $query
     * @param  int      $companyId
     * @return Builder
     */
    public function scopeMine($query)
    {
        $companyId = Auth::user()->company_id;

        return $query->where('company_id', '=', $companyId);
    }

    public function findMine($id)
    {
        //$query = static::query(['id' => $id])
    }

    /**
     * Find a model by its primary key.
     *
     * @param  mixed  $id
     * @param  array  $columns
     * @return \Illuminate\Support\Collection|static|null
     */
    public static function find($id, $columns = array('*'))
    {
        $query = static::query();

        if ( ! Auth::user()->isAdmin())
        {
            $query = $query->where('company_id', '=', Auth::user()->company_id);
        }

        return $query->find($id, $columns);
    }

    /**
     * Find a model by its primary key or throw an exception.
     *
     * @param  mixed  $id
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public static function findOrFail($id, $columns = array('*'))
    {
        $query = static::query();

        if ( ! Auth::user()->isAdmin())
        {
            $query = $query->where('company_id', '=', Auth::user()->company_id);
        }

        $result = $query->find($id, $columns);

        if (is_array($id))
        {
            if (count($result) == count(array_unique($id))) return $result;
        }
        elseif ( ! is_null($result))
        {
            return $result;
        }

        throw (new ModelNotFoundException)->setModel(get_class($this->model));
    }

    /**
     * Saves the model to the database.
     *
     * @param  array  $options
     * @return bool
     */
    public function save(array $options = array())
    {
        if (Auth::user()->isAdmin())
        {
            if ($this->company_id)
            {
                // Do nothing
            }
            else
            {
                $this->company_id = Auth::user()->company_id;
            }
        }
        else
        {
            $this->company_id = Auth::user()->company_id;
        }

        return parent::save($options);
    }
}
