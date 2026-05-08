import { z } from 'astro:content';

export const scheduleRowSchema = z.object({
  code: z.string(),
  type: z.enum(['INTENSIVE', 'MORNING', 'EVENING', 'BEGINNER', 'PRIVATE']),
  level: z.string(),
  programme: z.string(),
  hours: z.number().int().positive(),
  weeks: z.number().int().positive(),
  priceEur: z.number().nonnegative(),
  startDate: z.string().regex(/^\d{4}-\d{2}-\d{2}$/),
  endDate: z.string().regex(/^\d{4}-\d{2}-\d{2}$/),
  year: z.number().int(),
  days: z.string(),
  times: z.string(),
  registerUrl: z.string(),
});

export const scheduleSchema = z.array(scheduleRowSchema);
export type ScheduleRow = z.infer<typeof scheduleRowSchema>;
