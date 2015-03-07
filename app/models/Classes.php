<?php
class Classes extends Eloquent {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $primaryKey='classid';
    protected $foreignKey='moduleid';
    protected $table = 'classes';
    public $timestamps = false;
    /**
     * Whitelisted model properties for mass assignment.
     *
     * @var array
     */
    protected $fillable = array('lecturerid', 'classtimetable', 'studentsregistered', 'spacesavailable', 'totalspaces');
    /**
     * 
     */
    public function module()
    {
        return $this->belongsTo('Module', 'moduleid');
    }

    public function fromLecturer($lecturer)
    {
        return $this->where('lecturerid', $lecturer);
    }
}