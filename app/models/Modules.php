<?php
class Modules extends Eloquent {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'modules';
    protected $foreignKey='departmentid';
    public $timestamps = false;
    /**
     * Whitelisted model properties for mass assignment.
     *
     * @var array
     */
    protected $primaryKey = 'mid';

    protected $fillable = array('mfulltitle', 'mshorttitle', 'mdescription', 'mcode', 
        'mcrn', 'mfieldofstudy', 'mcoordinator','mlevel', 
        'mcredits', 'departmentid', 'mrequests');

    public function department()
    {
        return $this->belongsTo('Departments', 'departmentid');
    }

    public function classes()
    {
        return $this->hasMany('Classes', 'moduleid')->orderBy('classid', 'ASC');
    }

    public function getId(){
        return $this->primaryKey;
    }
}