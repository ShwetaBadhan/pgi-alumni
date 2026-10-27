<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::where('status', true)->get();
        return view('backend.pages.courses.index', compact('courses'));
    }

    public function create()
    {
        return view('backend.pages.courses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'home_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'detail_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'short_description' => 'required|string',
            'course_detail' => 'required|string',
            'course_overview' => 'required|string',
            'career_opportunities' => 'required|string',
            'downloads' => 'nullable|array',
            'status' => 'required|boolean',
        ]);

        // Upload Home Image
        if ($request->hasFile('home_image')) {
            $imageName = time() . '_home.' . $request->home_image->getClientOriginalExtension();
            $validated['home_image'] = $request->file('home_image')->storeAs('courses', $imageName, 'public');
        }

        // Upload Detail Image
        if ($request->hasFile('detail_image')) {
            $imageName = time() . '_detail.' . $request->detail_image->getClientOriginalExtension();
            $validated['detail_image'] = $request->file('detail_image')->storeAs('courses', $imageName, 'public');
        }

        // Handle downloads
        $validated['downloads'] = $request->downloads ?? [];

        Course::create($validated);
        return redirect()->route('courses.index')->with('success', 'Course created successfully!');
    }

    public function edit(Course $course)
    {
        return view('backend.pages.courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'home_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'detail_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'short_description' => 'required|string',
            'course_detail' => 'required|string',
            'course_overview' => 'required|string',
            'career_opportunities' => 'required|string',
            'downloads' => 'nullable|array',
            'status' => 'required|boolean',
        ]);

        // Upload Home Image
        if ($request->hasFile('home_image')) {
            if ($course->home_image && Storage::exists('public/' . $course->home_image)) {
                Storage::delete('public/' . $course->home_image);
            }
            $imageName = time() . '_home.' . $request->home_image->getClientOriginalExtension();
            $validated['home_image'] = $request->file('home_image')->storeAs('courses', $imageName, 'public');
        }

        // Upload Detail Image
        if ($request->hasFile('detail_image')) {
            if ($course->detail_image && Storage::exists('public/' . $course->detail_image)) {
                Storage::delete('public/' . $course->detail_image);
            }
            $imageName = time() . '_detail.' . $request->detail_image->getClientOriginalExtension();
            $validated['detail_image'] = $request->file('detail_image')->storeAs('courses', $imageName, 'public');
        }

        $validated['downloads'] = $request->downloads ?? [];

        $course->update($validated);
        return redirect()->route('courses.index')->with('success', 'Course updated successfully!');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Course deleted successfully!');
    }

    // Frontend: Show course details page with tabs
    public function show($slug)
    {
        $course = Course::where('slug', $slug)->where('status', true)->firstOrFail();
        return view('pages.courses.course-details', compact('course'));
    }
}