<?php
class Faculty extends Eloquent {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'faculty';
    public $timestamps = false;
    /**
     * Whitelisted model properties for mass assignment.
     *
     * @var array
     */
    protected $primaryKey='facultyid';

    protected $fillable = array('facultyname', 'facultyshort');

    public function departments()
    {
        return $this->hasMany('Departments', 'facultyid');
    }

    public function short()
    {
        return $this->facultyshort;
    }
}