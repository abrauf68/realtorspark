<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactFormController extends Controller
{
    public function contactSubmit(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'message' => 'required|string',
                'company_name' => 'nullable|string|max:255',
            ]);

            // Create new contact record
            $contact = Contact::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Thank you for contacting us!',
                'data' => [
                    'id' => $contact->id,
                    'name' => $contact->name,
                    'email' => $contact->email,
                    'message' => $contact->message,
                    'company_name' => $contact->company_name,
                ],
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again later.',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    public function updateContactSchedule(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'date' => 'required|date',
                'time' => 'required|date_format:Y-m-d H:i:s',
            ]);

            $contact = Contact::find($id);

            if (!$contact) {
                return response()->json([
                    'success' => false,
                    'message' => 'Contact not found.',
                ], 404);
            }

            $contact->update([
                'date' => $validated['date'],
                'time' => $validated['time'],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Contact schedule updated successfully.',
                'data' => [
                    'name' => $contact->name,
                    'email' => $contact->email,
                    'message' => $contact->message,
                    'company_name' => $contact->company_name,
                    'date' => $contact->date,
                    'time' => $contact->time,
                ],
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while updating schedule.',
                'error' => $th->getMessage(),
            ], 500);
        }
    }
}
