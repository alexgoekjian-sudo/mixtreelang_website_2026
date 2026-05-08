import schedule from '../data/schedule.json';

export type CourseRow = {
  code: string;
  type: string;
  level: string;
  programme: string;
  hours: number;
  weeks: number;
  priceEur: number;
  startDate: string;
  endDate: string;
  year: number;
  days: string;
  times: string;
  registerUrl: string;
};

export type ScheduleFilter = {
  type?: string;
  level?: string;
  programme?: string;
  summerOnly?: boolean;
};

const ALL = schedule as CourseRow[];

export function findNext(filter: ScheduleFilter = {}): CourseRow | null {
  return findUpcoming(filter, 1)[0] ?? null;
}

export function findUpcoming(filter: ScheduleFilter = {}, limit = 10): CourseRow[] {
  const today = new Date();
  today.setHours(0, 0, 0, 0);
  return ALL
    .filter((r) => !filter.type || r.type === filter.type)
    .filter((r) => !filter.level || r.level === filter.level)
    .filter((r) => !filter.programme || r.programme === filter.programme)
    .filter((r) => {
      if (!filter.summerOnly) return true;
      const m = Number(r.startDate.slice(5, 7));
      return m === 7 || m === 8;
    })
    .filter((r) => new Date(r.startDate) >= today)
    .sort((a, b) => a.startDate.localeCompare(b.startDate))
    .slice(0, limit);
}

export function fmtDate(iso: string): string {
  return new Date(iso).toLocaleDateString('en-GB', {
    day: 'numeric',
    month: 'long',
    year: 'numeric',
  });
}

export function nextStartLabel(
  filter: ScheduleFilter = {},
  fallback = 'TBA',
): string {
  const next = findNext(filter);
  return next ? fmtDate(next.startDate) : fallback;
}
