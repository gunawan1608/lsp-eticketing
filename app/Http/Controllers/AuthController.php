<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }
    public function register()
    {
        return view('auth.register');
    }

    public function postRegister(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => User::ROLE_CUSTOMER,
        ]);

        return redirect('/login')->with('success', 'Akun pelanggan berhasil dibuat. Silakan masuk.');
    }

    public function postLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect('/dashboard');
        }

        return back()
            ->withInput($request->only('email'))
            ->with('error', 'Email atau kata sandi tidak sesuai.');
    }

    public function dashboard(Request $request)
    {
        if (Auth::user()->isAdmin()) {
            $scheduleSearch = trim((string) $request->input('schedule_search'));
            $transactionSearch = trim((string) $request->input('transaction_search'));

            $schedules = Schedule::query()
                ->search($scheduleSearch)
                ->orderBy('departure')
                ->paginate(8, ['*'], 'schedule_page')
                ->withQueryString();

            $bookingsQuery = Booking::query()
                ->with(['user', 'schedule', 'transaction']);

            if ($transactionSearch !== '') {
                $bookingsQuery->where(function (Builder $builder) use ($transactionSearch) {
                    $builder
                        ->where('bookings.status', 'like', '%' . $transactionSearch . '%')
                        ->orWhereHas('user', function (Builder $userQuery) use ($transactionSearch) {
                            $userQuery
                                ->where('name', 'like', '%' . $transactionSearch . '%')
                                ->orWhere('email', 'like', '%' . $transactionSearch . '%');
                        })
                        ->orWhereHas('schedule', function (Builder $scheduleQuery) use ($transactionSearch) {
                            $scheduleQuery
                                ->where('plane_name', 'like', '%' . $transactionSearch . '%')
                                ->orWhere('origin', 'like', '%' . $transactionSearch . '%')
                                ->orWhere('destination', 'like', '%' . $transactionSearch . '%');
                        })
                        ->orWhereHas('transaction', function (Builder $transactionQuery) use ($transactionSearch) {
                            $transactionQuery
                                ->where('transaction_code', 'like', '%' . $transactionSearch . '%')
                                ->orWhere('payment_method', 'like', '%' . $transactionSearch . '%')
                                ->orWhere('payer_name', 'like', '%' . $transactionSearch . '%')
                                ->orWhere('payer_email', 'like', '%' . $transactionSearch . '%');
                        });
                });
            }

            $bookings = $bookingsQuery
                ->latest()
                ->paginate(8, ['*'], 'transaction_page')
                ->withQueryString();

            $pendingApprovals = Transaction::query()
                ->where('payment_status', Transaction::STATUS_WAITING_APPROVAL)
                ->count();
            $completedTransactions = Transaction::query()
                ->where('payment_status', Transaction::STATUS_APPROVED)
                ->count();
            $activeSchedulesCount = Schedule::query()
                ->where('departure', '>', now())
                ->count();

            return view('admin.dashboard', compact(
                'schedules',
                'bookings',
                'pendingApprovals',
                'completedTransactions',
                'activeSchedulesCount',
                'scheduleSearch',
                'transactionSearch'
            ));
        }

        $search = trim((string) $request->input('search'));

        $schedules = Schedule::query()
            ->search($search)
            ->orderBy('departure')
            ->paginate(8)
            ->withQueryString();

        return view('user.dashboard', compact('schedules', 'search'));
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/');
    }
}
