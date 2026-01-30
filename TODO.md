# TODO: Fix "N/A" Display in Profile Edit View

## Problem
The profile edit view was showing "N/A" for Department, Designation, and Shift fields instead of the actual names.

## Root Cause
- The view was accessing `$user->employeeProfile->department->name`, but the Department model had the attribute `department_name`, not `name`.
- Similarly for Designation (`designation_name`) and Shift (`shift_name`).
- The EmployeeSeeder was using incorrect keys (`name` instead of `department_name`, `title` instead of `designation_name`).
- EmployeeController required `shift_id` but migration allows nullable.

## Fixes Applied
- [x] Updated EmployeeSeeder to use correct column names: `department_name`, `designation_name`.
- [x] Added `getNameAttribute()` accessors to Department, Designation, and Shift models to return the respective name attributes.
- [x] Changed `shift_id` validation in EmployeeController from `required` to `nullable` in both store and update methods.

## Next Steps
- [ ] Test the application to ensure Department, Designation, and Shift names display correctly in the profile edit view.
- [ ] Run database migrations and seeders to apply the fixes.
- [ ] Verify that existing data is correctly populated.
