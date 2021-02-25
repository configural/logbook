<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Contract;
use Auth;
use Illuminate\Support\Facades\DB;



class userController extends Controller
{
    //
    
    public function update_profile(Request $request) {
        $errors = Array();
        $user = User::find(Auth::user()->id);
        $user->name = $request->name;
        
        if ($request->password) {
        if ($request->password == $request->confirm_password) {
            $user->password = bcrypt($request->password);
        } else {$errors[] = "Введенные пароли не совпадают"; }}
        if (count($errors)) {
            return view('info', ['html' => implode("<br/>", $errors)]);
        } else {
            $user->save();
            return redirect(route('home'));
        }
    }


    public function showUsers() {
        // возвращает список пользователей
        return view('users');
    }

    public function add(Request $request) {
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role_id = $request->role_id;
        $user->department_id = $request->department_id;
        $user->freelance = $request->freelance;
        $user->table_number = $request->table_number;
        $user->save();
        return view('users');
        
    }
    
    public function edit(Request $request) {
        $id = $request->id;
        $user = User::find($id);
        return view('useredit', ['user' => $user]);
        
    }
    
    
    
    public function store(Request $request) {
        $user = User::find($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->department_id = $request->department_id;
        $user->freelance = $request->freelance;
        $user->table_number = $request->table_number;
        $user->save();
        return redirect('users');
    }
   
    
    public function login_as($id) {
        if (in_array(Auth::user()->role_id, [3, 4, 6])) {
            $user = \App\User::find($id);
            if ($user->role_id == 2) 
                {Auth::loginUsingId($id); 
                return redirect('home');
                }
            else {
                return view('info', ['html' => "Вы пытаетесь залогигиться как " . $user->role->name . ". Из соображений безопасности можно логиниться только в профили преподавателей. В остальные роли - нельзя!"]);
            }
            
        } else {
            return view('info', ['html' => "У вас нет прав доступа"]);
        }
    }
    
    public function editcontract(Request $request) {
        $id = $request->id;
        
        $contract = Contract::find($id);
        
        //dd($contract);
        
        return view('usercontractedit', ['contract' => $contract]);
        
    }
    
    public function storecontract(Request $request) {
        if ($request->id) {
            $contract = Contract::find($request->id);
        } else {
            $contract = new Contract();
        }
        $contract->fill($request->all());
        $contract->save();
        
        if ($request->fill) {
            DB::table('teachers2timetable')
                    ->where('teacher_id', '=', $request->user_id)
                    ->whereNull('contract_id')
                    ->update(['contract_id' => $contract->id]);
        }
        return redirect(url('/user/')."/".$contract->user_id."/edit" );
    }
    
    public function deletecontract(Request $request) {
        $id = $request->id;
        $contract = Contract::find($id);
        $user_id = $contract->user_id;
        DB::table('teachers2timetable')
                ->where('teacher_id', '=', $user_id)
                ->where('contract_id', '=', $id)
                ->update(['contract_id' => NULL]);
        $contract->delete();
        return redirect(url('/user/')."/".$user_id."/edit" );
        
    }
        
    public function teacher_busy($user_id, $date, $start_at='00:00:00', $finish_at='23:59:59', $timetable_id = 0) {
        //if(!$date) $date = date('Y-m-d');
        $busy = false;
        
        $rasp = \App\Rasp::select()->where('date', $date)->orderBy('start_at')->get();
        echo "<strong><span class='red'> " . User::find($user_id)->name . "</span></strong><br>";
 
        if(trim($date)) :
           foreach($rasp as $r) {
           foreach($r->timetable->teachers as $teacher) {
               
               $cross = false;
               if (     ($start_at>=$r->start_at && $finish_at<=$r->finish_at) or
                        ($start_at<=$r->start_at && $finish_at>=$r->finish_at) or
                        ($finish_at>=$r->start_at && $finish_at<=$r->finish_at) or
                        ($start_at>=$r->start_at && $start_at<=$r->finish_at)
                       )
               {$cross = true;}
               
               if ($teacher->id == $user_id) { 
               echo "<div ";
               if ($cross == true) echo " class='cross' ";
                   echo">";
                echo $r->id . ": ";
                if ($r->start_at and $r->finish_at){
                echo "" . str_limit($r->start_at, 5, '') . " - ";
                echo "" . str_limit($r->finish_at, 5, '') . ", ";}
                else {
                    echo "Время не указано - ";
                }
                if ($r->classroom) {
                    echo "ауд. ". @$r->classroom->name . "";
                } else {
                    echo "Аудитория не указана";
                }
               echo "</div>";}
           }
            
        }
       
        endif;

        //dump($date);
        if (User::find($user_id)->freelance) {
            $contract_find = DB::table('teachers2timetable')->where('timetable_id', '=', $timetable_id)->where('teacher_id', $user_id)->first();
            //dump($contract_find);
            if ($contract_find) {$contract_selected = $contract_find->contract_id;}
            else {$contract_selected=0;
            }
            
            $contracts = User::find($user_id)->contracts;
            if ($contracts) {
            // dump($contract_selected);
            echo "Выберите договор: ";
            echo "<select name='contract_id' class='form-control-static' required>";
            echo "<option value=''>Не выбран</option>";
            foreach($contracts as $contract) {
                if ($contract->id == $contract_selected) {
                echo "<option value=" . $contract->id. " selected>" . $contract->name . "</option>";
                } else {
                echo "<option value=" . $contract->id. ">" . $contract->name . "</option>";
                }  
            }
            echo "</select>";
            echo "<a href='" . url('/') . "/user/" . $user_id . "/edit'> Договоры пользователя</a>";
            }
        
            
        }
        echo "<hr>";
        
    }
    
    function user_contracts(Request $request) {
        $user_id = $request->user_id;
        if (\App\User::find($user_id)->freelance) {
        $contracts = \App\Contract::select()->where('active', 1)->where('user_id', $request->user_id)->get();
        
        echo "<label>По какому контракту?</label> <select name='contract_id' class='form-control-static'>";
        foreach($contracts as $contract) {
            echo "<option value='$contract->id'>" . $contract->name . " от " . $contract->date . "(" . $contract->price . " руб./ч)</option>";
        }
        echo "</select>";
        }
    }
    
    
        function user_contracts_by_month(Request $request) {
           // dump($request);
            $month = $request->year . "-" . sprintf("%02d", $request->month);
            $contracts = \App\Contract::selectRaw('contracts.id as contract_id, users.name as username')
                    ->distinct()
                    ->join('users', 'users.id', '=', 'contracts.user_id')
                    ->join('teachers2timetable', 'teachers2timetable.teacher_id', '=', 'users.id')
                    ->join('timetable', 'timetable.id', '=', 'teachers2timetable.timetable_id')
                    ->join('groups', 'timetable.group_id', '=', 'groups.id')
                    ->join('streams', 'streams.id', '=', 'groups.stream_id')
                    ->join('rasp', 'rasp.id', '=', 'timetable.rasp_id')
                   // ->where('teachers2timetable.contract_id', 'contracts.id')
                    ->where('streams.year', $request->year)
                    ->where('timetable.month', $request->month)
                    ->where('groups.paid', $request->paid)
                    ->where('users.freelance', 1)
                    ->orderBy('users.name')
                    ->get();
            echo "<ol>";
            foreach($contracts as $contract) {
                echo "<li><a href=" . url('/'). "/reports/akt/$contract->contract_id/$request->year/$request->month/$request->paid/$request->akt_date/$request->rektor>" . $contract->username . "</a></li>";
            }
            echo "</ol>";
            
            }
    
    
    
}
