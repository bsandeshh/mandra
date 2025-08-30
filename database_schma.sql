-- WARNING: This schema is for context only and is not meant to be run.
-- Table order and constraints may not be valid for execution.

CREATE TABLE public.admissions (
  id uuid NOT NULL DEFAULT gen_random_uuid(),
  full_name text,
  age integer,
  mother_name text,
  religion text,
  mother_tongue text,
  dob date,
  address text,
  class_to_join text,
  previous_school text,
  contact_number text,
  submitted_at timestamp with time zone DEFAULT now(),
  CONSTRAINT admissions_pkey PRIMARY KEY (id)
);
CREATE TABLE public.appointments (
  id uuid NOT NULL DEFAULT gen_random_uuid(),
  guardian_name text,
  guardian_email text,
  child_name text,
  child_age text,
  message text,
  submitted_at timestamp with time zone DEFAULT now(),
  CONSTRAINT appointments_pkey PRIMARY KEY (id)
);
CREATE TABLE public.newsletter_subscriptions (
  id uuid NOT NULL DEFAULT gen_random_uuid(),
  email text,
  submitted_at timestamp with time zone DEFAULT now(),
  CONSTRAINT newsletter_subscriptions_pkey PRIMARY KEY (id)
);