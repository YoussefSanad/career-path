<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class JobPostController extends Controller
{

    /**
     * Create a new JobPostController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['admin'], ['except' => ['index']]);
    }

    /**
     * List all jop posts.
     *
     * @return string
     */
    public function index()
    {
        return self::respond(JobPost::where('start_date', '<', Carbon::now())
            ->where('end_date', '>', Carbon::now())
            ->get()->toArray());
    }

    /**
     * @param $jobPostId
     * @return string
     */
    public function show($jobPostId)
    {
        $jobPost = JobPost::find($jobPostId);
        return $jobPost ?
            self::respond($jobPost) :
            self::respond(null, false, 'Job post not found.');
    }

    /**
     * @param Request $request
     * @return false|string
     */
    public function store(Request $request)
    {
        $validator = self::validateInput($request);
        if ($validator->fails()) self::respond($validator->errors(), false, 'Validation Faild');
        try
        {
            return self::respond(self::createJobPost($request));
        } catch (\Exception $e)
        {
            return self::respond(null, false, $e->getMessage());
        }

    }

    /**
     * @param $jobPostId
     * @param Request $request
     * @return false|string
     */
    public function update($jobPostId, Request $request)
    {
        $validator = self::validateInput($request);
        if ($validator->fails()) self::respond($validator->errors(), false, 'Validation Faild');
        try
        {
            return self::respond(self::updateJobPost($jobPostId, $request));
        } catch (\Exception $e)
        {
            return self::respond(null, false, $e->getMessage());
        }
    }

    /**
     * @param $jobPostId
     * @return false|string
     */
    public function destroy($jobPostId)
    {
        try{
            $jobPost = JobPost::find($jobPostId);
            self::deleteJobPostApplicationsFiles($jobPost);
            $jobPost->applications()->delete();
            $jobPost->delete();
            return self::respond('Jop post deleted successfully.');
        }catch(\Exception $e){
            return self::respond(null, false, $e);
        }
    }

    /**
     * deletes all the files related to the job's applications
     * @param JobPost $jobPost
     */
    static private function deleteJobPostApplicationsFiles(JobPost $jobPost)
    {
        foreach ($jobPost->applications as $application)
        {
            Storage::delete($application->attachment_path);
        }
    }


    /**
     * @param $data
     * @param bool $success
     * @param null $error
     * @return false|string
     */
    private static function respond($data, $success = true, $error = null)
    {
        $response = ['success' => $success, 'payload' => $data, 'error' => $error];
        return json_encode($response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    private static function validateInput(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'                     => 'required|string',
            'required_experience_level' => 'required|string',
            'job_requirements'          => 'required|string',
            'start_date'                => 'required|date',
            'end_date'                  => 'required|date',
        ]);
        return $validator;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    private static function createJobPost(Request $request)
    {
        return JobPost::create([
            'user_id'                   => auth()->user()->id,
            'title'                     => $request->title,
            'required_experience_level' => $request->required_experience_level,
            'job_requirements'          => $request->job_requirements,
            'start_date'                => Carbon::parse($request->start_date),
            'end_date'                  => Carbon::parse($request->end_date),
        ]);
    }

    /**
     * @param $jobPostId
     * @param Request $request
     * @return false|string |null
     * @throws \Exception
     */
    private static function updateJobPost($jobPostId, Request $request)
    {
        $jobPost = JobPost::find($jobPostId);
        if (!$jobPost) throw new \Exception('Job post not found');
        $jobPost->update([
            'user_id'                   => auth()->user()->id,
            'title'                     => $request->title,
            'required_experience_level' => $request->required_experience_level,
            'job_requirements'          => $request->job_requirements,
            'start_date'                => Carbon::parse($request->start_date),
            'end_date'                  => Carbon::parse($request->end_date),
        ]);
        return JobPost::find($jobPostId);
    }
}
