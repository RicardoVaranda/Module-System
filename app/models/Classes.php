<?php
class Classes extends Eloquent {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $primaryKey='classid';
    protected $foreignKey='classmodule';
    protected $table = 'classes';
    public $timestamps = false;
    /**
     * Whitelisted model properties for mass assignment.
     *
     * @var array
     */
<<<<<<< Updated upstream
    protected $fillable = array('classlecturer', 'classstudents', 'classmodule', 'classlimit', 'classtimes', 'created');
=======
    protected $fillable = array('classlecturer', 'classstudents', 'classmodule', 'classlimit', 'classtimes', 'classrequests');
>>>>>>> Stashed changes
    /**
     * 
     */
    public function module()
    {
        return $this->belongsTo('Modules', 'classmodule');
    }

    public function fromLecturer($lecturer)
    {
        return $this->where('lecturerid', $lecturer);
    }

    public function getEmails() {
        $result = "";
        foreach(json_decode($this->classstudents) as $student) {
            $result = $result.User::find($student)->email.',';
        }

        return $result;
    }
}