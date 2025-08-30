drop extension if exists "pg_net";


  create table "public"."admissions" (
    "id" uuid not null default gen_random_uuid(),
    "full_name" text,
    "age" integer,
    "mother_name" text,
    "religion" text,
    "mother_tongue" text,
    "dob" date,
    "address" text,
    "class_to_join" text,
    "previous_school" text,
    "contact_number" text,
    "submitted_at" timestamp with time zone default now()
      );


alter table "public"."admissions" enable row level security;


  create table "public"."appointments" (
    "id" uuid not null default gen_random_uuid(),
    "guardian_name" text,
    "guardian_email" text,
    "child_name" text,
    "child_age" text,
    "message" text,
    "submitted_at" timestamp with time zone default now()
      );


alter table "public"."appointments" enable row level security;


  create table "public"."newsletter_subscriptions" (
    "id" uuid not null default gen_random_uuid(),
    "email" text,
    "submitted_at" timestamp with time zone default now()
      );


alter table "public"."newsletter_subscriptions" enable row level security;

CREATE UNIQUE INDEX admissions_pkey ON public.admissions USING btree (id);

CREATE UNIQUE INDEX appointments_pkey ON public.appointments USING btree (id);

CREATE UNIQUE INDEX newsletter_subscriptions_pkey ON public.newsletter_subscriptions USING btree (id);

alter table "public"."admissions" add constraint "admissions_pkey" PRIMARY KEY using index "admissions_pkey";

alter table "public"."appointments" add constraint "appointments_pkey" PRIMARY KEY using index "appointments_pkey";

alter table "public"."newsletter_subscriptions" add constraint "newsletter_subscriptions_pkey" PRIMARY KEY using index "newsletter_subscriptions_pkey";

grant delete on table "public"."admissions" to "anon";

grant insert on table "public"."admissions" to "anon";

grant references on table "public"."admissions" to "anon";

grant select on table "public"."admissions" to "anon";

grant trigger on table "public"."admissions" to "anon";

grant truncate on table "public"."admissions" to "anon";

grant update on table "public"."admissions" to "anon";

grant delete on table "public"."admissions" to "authenticated";

grant insert on table "public"."admissions" to "authenticated";

grant references on table "public"."admissions" to "authenticated";

grant select on table "public"."admissions" to "authenticated";

grant trigger on table "public"."admissions" to "authenticated";

grant truncate on table "public"."admissions" to "authenticated";

grant update on table "public"."admissions" to "authenticated";

grant delete on table "public"."admissions" to "service_role";

grant insert on table "public"."admissions" to "service_role";

grant references on table "public"."admissions" to "service_role";

grant select on table "public"."admissions" to "service_role";

grant trigger on table "public"."admissions" to "service_role";

grant truncate on table "public"."admissions" to "service_role";

grant update on table "public"."admissions" to "service_role";

grant delete on table "public"."appointments" to "anon";

grant insert on table "public"."appointments" to "anon";

grant references on table "public"."appointments" to "anon";

grant select on table "public"."appointments" to "anon";

grant trigger on table "public"."appointments" to "anon";

grant truncate on table "public"."appointments" to "anon";

grant update on table "public"."appointments" to "anon";

grant delete on table "public"."appointments" to "authenticated";

grant insert on table "public"."appointments" to "authenticated";

grant references on table "public"."appointments" to "authenticated";

grant select on table "public"."appointments" to "authenticated";

grant trigger on table "public"."appointments" to "authenticated";

grant truncate on table "public"."appointments" to "authenticated";

grant update on table "public"."appointments" to "authenticated";

grant delete on table "public"."appointments" to "service_role";

grant insert on table "public"."appointments" to "service_role";

grant references on table "public"."appointments" to "service_role";

grant select on table "public"."appointments" to "service_role";

grant trigger on table "public"."appointments" to "service_role";

grant truncate on table "public"."appointments" to "service_role";

grant update on table "public"."appointments" to "service_role";

grant delete on table "public"."newsletter_subscriptions" to "anon";

grant insert on table "public"."newsletter_subscriptions" to "anon";

grant references on table "public"."newsletter_subscriptions" to "anon";

grant select on table "public"."newsletter_subscriptions" to "anon";

grant trigger on table "public"."newsletter_subscriptions" to "anon";

grant truncate on table "public"."newsletter_subscriptions" to "anon";

grant update on table "public"."newsletter_subscriptions" to "anon";

grant delete on table "public"."newsletter_subscriptions" to "authenticated";

grant insert on table "public"."newsletter_subscriptions" to "authenticated";

grant references on table "public"."newsletter_subscriptions" to "authenticated";

grant select on table "public"."newsletter_subscriptions" to "authenticated";

grant trigger on table "public"."newsletter_subscriptions" to "authenticated";

grant truncate on table "public"."newsletter_subscriptions" to "authenticated";

grant update on table "public"."newsletter_subscriptions" to "authenticated";

grant delete on table "public"."newsletter_subscriptions" to "service_role";

grant insert on table "public"."newsletter_subscriptions" to "service_role";

grant references on table "public"."newsletter_subscriptions" to "service_role";

grant select on table "public"."newsletter_subscriptions" to "service_role";

grant trigger on table "public"."newsletter_subscriptions" to "service_role";

grant truncate on table "public"."newsletter_subscriptions" to "service_role";

grant update on table "public"."newsletter_subscriptions" to "service_role";


