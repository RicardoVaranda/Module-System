<?php
class Departments extends Eloquent {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'departments';

    public $timestamps = false;
    /**
     * Whitelisted model properties for mass assignment.
     *
     * @var array
     */
    protected $primaryKey='departmentid';
    protected $foreignKey='facultyid';

    protected $fillable = array('departmentname', 'departmenthead', 'facultyid');

    public function modules()
    {
        return $this->hasMany('Modules', 'departmentid');
    }
    public function faculty()
    {
        return $this->belongsTo('Faculty', 'facultyid');
    }
    public function name()
    {
        return $this->departmentname;
    }
}