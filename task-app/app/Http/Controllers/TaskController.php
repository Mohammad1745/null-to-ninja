<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\TaskStoreRequest;
use App\Http\Requests\Task\TaskUpdateRequest;
use App\Models\Task;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index (): View|Factory|Application
    {
        $data['header'] = "Task List";
        $data['tasks'] = Task::where('user_id', Auth::id())->get();

        return view('task.index', $data);
    }

    /**
     * @return Factory|View|Application
     */
    public function create (): Factory|View|Application
    {
        return view('task.create');
    }

    /**
     * @param TaskStoreRequest $request
     * @return RedirectResponse
     */
    public function store (TaskStoreRequest $request): RedirectResponse
    {
        $allData = $request->all();

        $data =  [
            'user_id' => Auth::id(),
            'title' => $allData['title'],
            'description' => $allData['description']
        ];

        Task::create($data);
        return redirect()->route('task.index')->with('success', "Task added successfully.");
    }

    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function show ($id): View|Factory|Application
    {
        $data['task'] = Task::find($id);
        return view('task.show', $data);
    }

    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function edit ($id): View|Factory|Application
    {
        $data['task'] = Task::find($id);
        return view('task.edit', $data);
    }

    /**
     * @param TaskUpdateRequest $request
     * @return RedirectResponse
     */
    public function update (TaskUpdateRequest $request): RedirectResponse
    {
        $allData = $request->all();
        $id = $allData['id'];
        $task = Task::find($id);
        if (is_null($task)) {
            return redirect()->back()->with('error', "Task doesn't exist!");
        }

        $data =  [
            'title' => $allData['title'],
            'description' => $allData['description']
        ];
        Task::where('id', $id)->update($data);

        return redirect()->route('task.show', $id)->with('success', "Task updated successfully.");
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function destroy ($id): RedirectResponse
    {
        $task = Task::find($id);
        if (is_null($task)) {
            return redirect()->back()->with('error', "Task doesn't exist!");
        }
        $task->delete();

        return redirect()->route('task.index')->with('success', "Task deleted successfully.");
    }
}
